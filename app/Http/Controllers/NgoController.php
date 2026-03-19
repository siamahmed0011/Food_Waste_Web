<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PickupRequest;
use Illuminate\Support\Facades\Auth;

class NgoController extends Controller
{
    public function index()
{
    $ngoId = auth()->id();

    $base = \App\Models\PickupRequest::with(['foodPost', 'donor'])
        ->where('ngo_user_id', $ngoId);

    $stats = [
        'total'     => (clone $base)->count(),
        'pending'   => (clone $base)->where('status', 'pending')->count(),
        'completed' => (clone $base)->where('status', 'completed')->count(),
    ];

    $recent = (clone $base)
        ->latest()
        ->take(10) // view এ last 3 দেখাবে, এটা extra safe
        ->get();

    return view('pages.ngos.index', compact('stats', 'recent'));
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
