<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use App\Models\FoodPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // ========== PROFILE MAIN PAGE ==========
    public function index()
    {
        $user = Auth::user();

        // donation stats
        $query = FoodPost::where('user_id', $user->id);

        $totalPosts     = $query->count();
        $availableCount = (clone $query)->where('status', 'available')->count();
        $completedCount = (clone $query)->where('status', 'completed')->count();

        return view('pages.donor.profile', [
            'user'           => $user,
            'totalPosts'     => $totalPosts,
            'availableCount' => $availableCount,
            'completedCount' => $completedCount,
        ]);
    }

    // ========== EDIT PROFILE FORM ==========
    public function edit()
    {
        $user = Auth::user();
        return view('pages.donor.profile_edit', compact('user'));
    }

    // ========== UPDATE PROFILE DATA ==========
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
            'image'   => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profile_images', 'public');
            $user->image = $path;
        }

        $user->name    = $request->name;
        $user->phone   = $request->phone;
        $user->address = $request->address;
        $user->save();

        return redirect()
            ->route('donor.profile')
            ->with('success', 'Profile updated successfully!');
    }

    // ========== PASSWORD FORM ==========
    public function passwordForm()
    {
        return view('pages.donor.change_password');
    }

    // ========== UPDATE PASSWORD ==========
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password'     => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Old password is incorrect']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()
            ->route('donor.profile')
            ->with('success', 'Password updated successfully!');
    }
}
