<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use App\Models\FoodPost;
use App\Models\PickupRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PickupController extends Controller
{
    // Donor pickup requests list (own posts)
    public function index(Request $request)
    {
        $donorId = Auth::id();
        $status = $request->query('status'); // optional filter

        $query = PickupRequest::with(['foodPost', 'ngo'])
            ->where('donor_user_id', $donorId)
            ->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $pickups = $query->paginate(15);

        return view('pages.donor.pickups.index', compact('pickups', 'status'));
    }

    // Approve (transaction + auto reject others + food reserved)
    public function approve(PickupRequest $pickupRequest, Request $request)
    {
        if ((int)$pickupRequest->donor_user_id !== (int)Auth::id()) {
            abort(403);
        }

        $request->validate([
            'final_pickup_at' => ['nullable', 'date'],
        ]);

        DB::transaction(function () use ($pickupRequest, $request) {

            $pickup = PickupRequest::query()
                ->lockForUpdate()
                ->findOrFail($pickupRequest->id);

            $food = FoodPost::query()
                ->lockForUpdate()
                ->findOrFail($pickup->food_post_id);

            if ($pickup->status !== 'pending') {
                abort(422, 'This request is not pending.');
            }

            if ($food->status !== 'available') {
                abort(422, 'Food post is not available.');
            }

            $pickup->update([
                'status' => 'approved',
                'approved_at' => now(),
                'final_pickup_at' => $request->input('final_pickup_at') ?: null,
            ]);

            $food->update([
                'status' => 'reserved',
            ]);

            PickupRequest::query()
                ->where('food_post_id', $food->id)
                ->where('id', '!=', $pickup->id)
                ->where('status', 'pending')
                ->update([
                    'status' => 'rejected',
                    'rejected_at' => now(),
                    'rejected_reason' => 'Another NGO request was approved.',
                ]);
        });

        return back()->with('success', 'Pickup request approved.');
    }

    public function reject(PickupRequest $pickupRequest, Request $request)
    {
        if ((int)$pickupRequest->donor_user_id !== (int)Auth::id()) {
            abort(403);
        }

        $request->validate([
            'reason' => ['nullable', 'string', 'max:255'],
        ]);

        if ($pickupRequest->status !== 'pending') {
            return back()->with('error', 'Only pending requests can be rejected.');
        }

        $pickupRequest->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'rejected_reason' => $request->input('reason') ?: 'Rejected by donor.',
        ]);

        return back()->with('success', 'Pickup request rejected.');
    }

    public function pickedUp(PickupRequest $pickupRequest)
    {
        if ((int)$pickupRequest->donor_user_id !== (int)Auth::id()) {
            abort(403);
        }

        if ($pickupRequest->status !== 'approved') {
            return back()->with('error', 'Only approved requests can be marked as picked up.');
        }

        $pickupRequest->update([
            'status' => 'picked_up',
            'picked_up_at' => now(),
        ]);

        return back()->with('success', 'Marked as picked up.');
    }

    public function complete(PickupRequest $pickupRequest)
    {
        if ((int)$pickupRequest->donor_user_id !== (int)Auth::id()) {
            abort(403);
        }

        if (!in_array($pickupRequest->status, ['approved', 'picked_up'], true)) {
            return back()->with('error', 'Only approved/picked up requests can be completed.');
        }

        DB::transaction(function () use ($pickupRequest) {
            $pickup = PickupRequest::query()->lockForUpdate()->findOrFail($pickupRequest->id);
            $food = FoodPost::query()->lockForUpdate()->findOrFail($pickup->food_post_id);

            $pickup->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            $food->update([
                'status' => 'completed',
            ]);
        });

        return back()->with('success', 'Pickup completed successfully.');
    }
}
