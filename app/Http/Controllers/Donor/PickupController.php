<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use App\Models\PickupRequest;
use App\Models\FoodPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PickupController extends Controller
{
    // Donor: incoming pickup requests list
    public function index(Request $request)
    {
        $user = Auth::user();
        $status = $request->query('status');

        $q = PickupRequest::with(['foodPost', 'ngo'])
            ->where('donor_user_id', $user->id)
            ->latest();

        if ($status) {
            $q->where('status', $status);
        }

        $pickups = $q->paginate(10)->withQueryString();

        return view('pages.donor.pickups.index', compact('pickups', 'status'));
    }

    // Approve one request + auto reject others (same food_post)
    public function approve(Request $request, PickupRequest $pickup)
    {
        $user = Auth::user();

        if ($pickup->donor_user_id !== $user->id) {
            abort(403);
        }

        if ($pickup->status !== 'pending') {
            return back()->with('error', 'Only pending requests can be approved.');
        }

        // optional final pickup time
        $final = $request->input('final_pickup_at');

        // Approve selected
        $pickup->update([
            'status'        => 'approved',
            'final_pickup_at' => $final ?: null,
            'approved_at'   => now(),
            'rejected_at'   => null,
            'rejected_reason' => null,
        ]);

        // FoodPost reserved
        if ($pickup->food_post_id) {
            FoodPost::where('id', $pickup->food_post_id)->update(['status' => 'reserved']);

            // Auto reject other pending requests for same post
            PickupRequest::where('food_post_id', $pickup->food_post_id)
                ->where('id', '!=', $pickup->id)
                ->where('status', 'pending')
                ->update([
                    'status' => 'rejected',
                    'rejected_at' => now(),
                    'rejected_reason' => 'Another NGO was approved.',
                ]);
        }

        return back()->with('success', 'Pickup request approved.');
    }

    public function reject(Request $request, PickupRequest $pickup)
    {
        $user = Auth::user();

        if ($pickup->donor_user_id !== $user->id) {
            abort(403);
        }

        if (!in_array($pickup->status, ['pending', 'approved'])) {
            return back()->with('error', 'This request cannot be rejected now.');
        }

        $reason = $request->input('reason') ?: 'Rejected by donor';

        $pickup->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'rejected_reason' => $reason,
        ]);

        // if food reserved by this request, set back available only if no other approved exists
        if ($pickup->food_post_id) {
            $hasApproved = PickupRequest::where('food_post_id', $pickup->food_post_id)
                ->where('status', 'approved')
                ->exists();

            if (!$hasApproved) {
                FoodPost::where('id', $pickup->food_post_id)->update(['status' => 'available']);
            }
        }

        return back()->with('success', 'Pickup request rejected.');
    }

    public function pickedUp(PickupRequest $pickup)
    {
        $user = Auth::user();

        if ($pickup->donor_user_id !== $user->id) {
            abort(403);
        }

        if ($pickup->status !== 'approved') {
            return back()->with('error', 'Only approved requests can be marked picked up.');
        }

        $pickup->update([
            'status' => 'picked_up',
            'picked_up_at' => now(),
        ]);

        return back()->with('success', 'Marked as picked up.');
    }

    public function complete(PickupRequest $pickup)
    {
        $user = Auth::user();

        if ($pickup->donor_user_id !== $user->id) {
            abort(403);
        }

        if (!in_array($pickup->status, ['approved', 'picked_up'])) {
            return back()->with('error', 'This request cannot be completed now.');
        }

        $pickup->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        // FoodPost completed
        if ($pickup->food_post_id) {
            FoodPost::where('id', $pickup->food_post_id)->update(['status' => 'completed']);
        }

        return back()->with('success', 'Pickup completed.');
    }
}
