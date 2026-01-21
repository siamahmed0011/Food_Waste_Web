<?php

namespace App\Http\Controllers;

use App\Models\PickupRequest;
use App\Models\FoodPost;
use App\Models\Ngo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\DonationAcceptedNotification;

class NgoOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 1️⃣ NGO Orders List (existing)
    public function index()
    {
        $user = Auth::user();

        // Logged-in user er sathe linked NGO row khujbo
        $ngo = Ngo::where('email', $user->email)->first();

        if (!$ngo) {
            $orders = collect();
        } else {
            $orders = PickupRequest::with(['donor', 'foodPost'])
                ->where('ngo_id', $ngo->id)
                ->latest()
                ->get();
        }

        return view('pages.ngos.orders', compact('orders'));
    }

    // 2️⃣ Show All Available Food Posts
    public function availableFoods()
    {
        $foods = FoodPost::with('donor')
            ->where('status', 'available')
            ->latest()
            ->get();

        return view('pages.ngos.available_foods', compact('foods'));
    }

    // 3️⃣ NGO Accepts Food Post
    //    route: POST /ngo/foods/{food}/accept  name: ngo.food.accept
    public function accept(FoodPost $food)
    {
        $user = Auth::user();

        // 🔹 3.1 – Ensure NGO record exists for this user (auto-create if missing)
        $ngo = Ngo::where('email', $user->email)->first();

        if (!$ngo) {
            $ngo = Ngo::create([
                'name'      => $user->organization_name ?? $user->name,
                'email'     => $user->email,
                'phone'     => $user->phone,
                'address'   => $user->address,
                'status'    => 'pending', // or 'approved' based on your logic
                'latitude'  => $user->latitude,
                'longitude' => $user->longitude,
            ]);
        }

        // 🔹 3.2 – stop accepting if already reserved/completed
        if ($food->status !== 'available') {
            return back()->with('error', 'This food is no longer available.');
        }

        // 🔹 3.3 – create pickup request
        PickupRequest::create([
            'ngo_id'       => $ngo->id,
            'donor_id'     => $food->user_id,
            'food_post_id' => $food->id,
            'food_title'   => $food->title,
            'pickup_time'  => $food->pickup_time_from,
            'status'       => 'accepted',
        ]);

        // 🔹 3.4 – update food status
        $food->update([
            'status' => 'reserved',
        ]);

        // 🔹 3.5 – notify donor (dashboard notification)
        $donor = $food->donor; // FoodPost model e donor() relation
        if ($donor) {
            $donor->notify(new DonationAcceptedNotification($ngo, $food));
        }

        return back()->with('success', 'Food Request Accepted Successfully!');
    }

    // 4️⃣ Update pickup order status (NGO panel theke)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,completed,cancelled',
        ]);

        $order = PickupRequest::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Order status updated.');
    }

    // 5️⃣ Single food details view for NGO
    public function showFood(FoodPost $food)
    {
        $donor = $food->donor;   // FoodPost model e donor() relation use korchi

        return view('pages.ngos.food_show', compact('food', 'donor'));
    }
}
