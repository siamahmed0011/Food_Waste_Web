<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PickupRequest;
use Illuminate\Support\Facades\Auth;

class NgoController extends Controller
{
    public function index()
    {
        $ngoId = Auth::id();

        $total = PickupRequest::where('ngo_user_id', $ngoId)->count();
        $pending = PickupRequest::where('ngo_user_id', $ngoId)->where('status', 'pending')->count();
        $completed = PickupRequest::where('ngo_user_id', $ngoId)->where('status', 'completed')->count();

        // Fetch more, dashboard will show only last 3
        $recent = PickupRequest::with(['foodPost', 'donor'])
            ->where('ngo_user_id', $ngoId)
            ->latest()
            ->take(10)
            ->get();

        return view('pages.ngos.index', [
            'stats' => [
                'total' => $total,
                'pending' => $pending,
                'completed' => $completed,
            ],
            'recent' => $recent,
        ]);
    }

    public function publicList()
    {
        $ngos = User::where('role', 'organization')->latest()->paginate(12);
        return view('pages.ngos.public', compact('ngos'));
    }

    public function allNgos()
    {
        $ngos = User::where('role', 'organization')->latest()->paginate(12);
        return view('pages.ngos.all_ngos', compact('ngos'));
    }

    public function donors()
    {
        $donors = User::where('role', 'donor')->latest()->paginate(12);
        return view('pages.ngos.donors', compact('donors'));
    }

    public function showDonor(User $user)
    {
        if ($user->role !== 'donor') {
            abort(404);
        }

        return view('pages.ngos.donor_show', [
            'donorUser' => $user
        ]);
    }

    public function updateSettings()
    {
        return back()->with('success', 'Settings updated.');
    }
}
