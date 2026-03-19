<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use App\Models\FoodPost;
use App\Models\User;
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
    $user = auth()->user();

    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'phone' => ['nullable', 'string', 'max:30'],
        'address' => ['nullable', 'string', 'max:255'],

        'donor_type' => ['nullable', 'string', 'max:50'],
        'organization_name' => ['nullable', 'string', 'max:255'],
        'pickup_address' => ['nullable', 'string', 'max:1000'],
        'pickup_time' => ['nullable', 'string', 'max:50'],
        'alt_phone' => ['nullable', 'string', 'max:30'],
        'pickup_notes' => ['nullable', 'string', 'max:1000'],

        'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
    ]);

    // profile image
    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('profiles', 'public');
    }

    $user->update($data);

    return redirect()->route('donor.profile')->with('success', 'Profile updated successfully.');
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

        // ========== VIEW NGO DETAILS (Donor) ==========
    public function showNgo(User $user)
    {
        // Only organization profiles allowed
        if ($user->role !== 'organization') {
            abort(404);
        }

        return view('pages.donor.ngo_show', [
            'ngoUser' => $user,
        ]);
    }

}
