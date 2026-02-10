<?php

namespace App\Http\Controllers\Ngo;

use App\Http\Controllers\Controller;
use App\Models\FoodPost;
use App\Models\PickupRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class NgoFoodController extends Controller
{
    public function index(Request $request)
    {
        $ngoId = auth()->id();

        $foods = FoodPost::with('donor')
            ->where('status', 'available')
            ->latest()
            ->paginate(10);

        // blocked statuses => these mean already requested (so disable Accept)
        $blockedStatuses = ['pending', 'approved', 'picked_up', 'completed'];

        $requestedMap = PickupRequest::where('ngo_user_id', $ngoId)
            ->whereIn('status', $blockedStatuses)
            ->get()
            ->keyBy('food_post_id');

        return view('pages.ngos.available_foods', [
            'foods' => $foods,
            'requestedMap' => $requestedMap,
        ]);
    }

    public function show(FoodPost $foodPost)
    {
        return view('pages.ngos.food_show', ['food' => $foodPost]);
    }

    public function accept(FoodPost $foodPost)
    {
        $user = Auth::user();

        if ($foodPost->status !== 'available') {
            return back()->with('error', 'This food is not available anymore.');
        }

        // If already exists (any status), handle safely
        $existing = PickupRequest::where('food_post_id', $foodPost->id)
            ->where('ngo_user_id', $user->id)
            ->first();

        if ($existing) {
            // If it's already requested (even if status changed), do not crash
            return back()->with('error', 'You already requested this post.');
        }

        try {
            PickupRequest::create([
                'food_post_id'     => $foodPost->id,
                'donor_user_id'    => $foodPost->user_id,
                'ngo_user_id'      => $user->id,
                'status'           => 'pending',
                'pickup_time_from' => $foodPost->pickup_time_from,
                'pickup_time_to'   => $foodPost->pickup_time_to,
                'contact_phone'    => $user->phone ?? null,
                'note'             => null,
            ]);
        } catch (QueryException $e) {
            // Unique constraint violation fallback (just in case of race condition)
            // pickup_requests_food_post_id_ngo_user_id_unique
            return back()->with('error', 'You already requested this post.');
        }

        return back()->with('success', 'Pickup request sent! Waiting for donor approval.');
    }
}
