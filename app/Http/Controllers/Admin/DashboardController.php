<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PickupRequest;
use App\Models\FoodPost;

class DashboardController extends Controller
{
    public function index()
 {
    // ===== Users =====
    $totalUsers  = User::count();
    $totalDonors = User::where('role', 'donor')->count();
    $totalNgos   = User::where('role', 'organization')->count();
    $totalAdmins = User::where('role', 'admin')->count();

    // ===== DONATIONS (accepted + completed) =====
    $totalDonations = PickupRequest::whereIn('status', ['accepted', 'completed'])->count();

    $donationsThisWeek = PickupRequest::whereIn('status', ['accepted', 'completed'])
        ->whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek(),
        ])
        ->count();

    // ===== OPEN REQUESTS (donor posts not yet accepted) =====
    $openRequests = FoodPost::where('status', 'available')->count();
    $pendingApprovals = $openRequests;

    // ===== AI SUMMARY STATS =====
    $totalFoodPosts   = FoodPost::count();
    $foodPostsLast7d  = FoodPost::where('created_at', '>=', now()->subDays(7))->count();
    $activePickups    = PickupRequest::where('status', 'accepted')->count();
    $completedThisWeek = PickupRequest::where('status', 'completed')
        ->where('created_at', '>=', now()->subDays(7))
        ->count();

    // Simple "AI-style" lines (later real AI connect korle easy hobe)
    $aiSummaryLines = [
        "In the last 7 days, {$foodPostsLast7d} new food posts were shared.",
        "So far, {$totalDonations} donations have been accepted or completed.",
        "Right now, {$openRequests} donor requests are still waiting for NGOs.",
        "{$completedThisWeek} pickups were completed in the last 7 days, and {$activePickups} are currently active.",
    ];

    // ===== RECENT ACTIVITY (latest pickups) =====
    $recentActivities = PickupRequest::with(['donor', 'ngo', 'foodPost'])
        ->latest()
        ->take(5)
        ->get();

    return view('pages.admin.dashboard', compact(
        'totalUsers',
        'totalDonors',
        'totalNgos',
        'totalAdmins',
        'totalDonations',
        'donationsThisWeek',
        'openRequests',
        'pendingApprovals',
        'totalFoodPosts',
        'foodPostsLast7d',
        'aiSummaryLines',
        'recentActivities'
 
   ));
 }
}
