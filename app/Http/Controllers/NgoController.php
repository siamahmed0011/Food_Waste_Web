<?php

namespace App\Http\Controllers;

use App\Models\Ngo;
use App\Models\User;
use App\Models\PickupRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NgoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ===========================
    // NGO DASHBOARD
    // ===========================
    public function index()
    {
        $user = Auth::user();

        // If logged-in user is an Organization
        if ($user->role === 'organization') {
            $ngo  = Ngo::where('email', $user->email)->first();
            $ngos = $ngo ? collect([$ngo]) : collect();
            $ngoId = $ngo?->id;
        }
        // If Admin → see all NGOs
        else {
            $ngos  = Ngo::latest()->get();
            $ngoId = null;
        }

        // Default stats
        $stats = [
            'total_pickups'     => 0,
            'pending_requests'  => 0,
            'completed_pickups' => 0,
        ];

        // If NGO is logged in → calculate real stats
        if ($ngoId) {
            $stats['total_pickups'] =
                PickupRequest::where('ngo_id', $ngoId)->count();

            $stats['pending_requests'] =
                PickupRequest::where('ngo_id', $ngoId)
                    ->where('status', 'pending')
                    ->count();

            $stats['completed_pickups'] =
                PickupRequest::where('ngo_id', $ngoId)
                    ->where('status', 'completed')
                    ->count();
        }

        return view('pages.ngos.index', compact('ngos', 'stats'));
    }

    // ===========================
    // NGO CREATE FORM
    // ===========================
    public function create()
    {
        return view('pages.ngos.create');
    }

    // ===========================
    // NGO STORE
    // ===========================
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:ngos,email',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'status'  => 'required|in:pending,approved,rejected',
        ]);

        Ngo::create($request->all());

        return redirect()->route('ngos.index')
            ->with('success', 'NGO created successfully.');
    }

    // ===========================
    // NGO EDIT FORM
    // ===========================
    public function edit(Ngo $ngo)
    {
        return view('pages.ngos.edit', compact('ngo'));
    }

    // ===========================
    // NGO UPDATE (Admin use)
    // ===========================
    public function update(Request $request, Ngo $ngo)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:ngos,email,' . $ngo->id,
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'status'  => 'required|in:pending,approved,rejected',
        ]);

        $ngo->update($request->all());

        return redirect()->route('ngos.index')
            ->with('success', 'NGO updated successfully.');
    }

    // ===========================
    // DELETE NGO
    // ===========================
    public function destroy(Ngo $ngo)
    {
        $ngo->delete();

        return redirect()->route('ngos.index')
            ->with('success', 'NGO deleted successfully.');
    }

    // ===========================
    // NGO SETTINGS UPDATE
    // ===========================
    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'organization_name' => 'required|string|max:255',
            'organization_type' => 'nullable|string|max:255',
            'phone'             => 'nullable|string|max:20',
            'address'           => 'nullable|string|max:255',
            'latitude'          => 'nullable|numeric',
            'longitude'         => 'nullable|numeric',
        ]);

        // Update logged-in user info
        $user->update([
            'organization_name' => $request->organization_name,
            'organization_type' => $request->organization_type,
            'phone'             => $request->phone,
            'address'           => $request->address,
        ]);

        // Update NGO row linked to this user email
        $ngo = Ngo::where('email', $user->email)->first();

        if ($ngo) {
            $ngo->update([
                'name'      => $request->organization_name,
                'phone'     => $request->phone,
                'address'   => $request->address,
                'latitude'  => $request->latitude,
                'longitude' => $request->longitude,
            ]);
        }

        return back()->with('success', 'Settings updated successfully!');
    }

    // ===========================
    // PUBLIC NGO LIST (optional)
    // ===========================
    public function publicList()
    {
        $ngos = Ngo::where('status', 'approved')
            ->orderBy('name')
            ->get();

        return view('pages.ngos.public', compact('ngos'));
    }

    // ===========================
    // ALL NGOS LIST (for NGO panel)
    // ===========================
    public function allNgos()
    {
        // sob NGO newest first
        $ngos = Ngo::latest()->get();

        return view('pages.ngos.all_ngos', compact('ngos'));
    }

    // ===========================
    // DONORS LIST (view only)
    // ===========================
    public function donors()
    {
        // sob donor user newest first
        $donors = User::where('role', 'donor')
            ->latest()
            ->get();

        return view('pages.ngos.donors', compact('donors'));
    }
}
