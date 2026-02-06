<?php

namespace App\Http\Controllers\Ngo;

use App\Http\Controllers\Controller;
use App\Models\FoodPost;
use App\Models\PickupRequest;
use Illuminate\Support\Facades\Auth;

class NgoFoodController extends Controller
{
    public function index()
    {
        $foods = FoodPost::where('status', 'available')
            ->latest()
            ->paginate(10);

        return view('pages.ngos.available_foods', compact('foods'));
    }

    public function show(FoodPost $foodPost)
    {
        return view('pages.ngos.food_show', ['food' => $foodPost]);
    }

    // ✅ NGO sends pickup request (pending)
    public function accept(FoodPost $foodPost)
    {
        $user = Auth::user();

        if ($foodPost->status !== 'available') {
            return back()->with('error', 'This food is not available anymore.');
        }

        // prevent duplicate request (same NGO same post)
        $exists = PickupRequest::where('food_post_id', $foodPost->id)
            ->where('ngo_user_id', $user->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'You already requested this post.');
        }

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

        return back()->with('success', 'Pickup request sent! Waiting for donor approval.');
    }
}
