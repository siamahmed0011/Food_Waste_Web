<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        
        $recentNotifications = $user->notifications()
            ->latest()
            ->take(2)
            ->get();

    
        $threeDaysNotifications = $user->notifications()
            ->where('created_at', '>=', now()->subDays(3))
            ->latest()
            ->get();

        return view('pages.donor.dashboard', compact(
            'user',
            'recentNotifications',
            'threeDaysNotifications'
        ));
    }
}
