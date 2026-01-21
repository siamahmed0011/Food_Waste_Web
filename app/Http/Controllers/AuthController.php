<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ngo;                 // 👈 NEW: Ngo model use
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showDonorRegisterForm()
    {
        return view('Auth.register_donor');
    }

    public function showOrganizationRegisterForm()
    {
        return view('Auth.register_organization');
    }

    public function showLoginForm()
    {
        return view('pages.login');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:donor,organization',
        ]);

        // ✅ address build
        $address = $request->address;

        if ($request->role === 'donor') {
            $addressParts = [
                $request->district,
                $request->city,
                $request->road_no,
                $request->house_no,
            ];

            $address = implode(', ', array_filter($addressParts));
        }

        // ✅ user create
        $user = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'role'              => $request->role,
            'phone'             => $request->phone,
            'organization_name' => $request->organization_name,
            'organization_type' => $request->organization_type,
            'address'           => $address,
        ]);

        // ✅ Jodi organization hole, sathe sathe NGOs table eo entry create
        if ($user->role === 'organization') {
            Ngo::create([
                'name'    => $user->organization_name ?? $user->name,
                'email'   => $user->email,
                'phone'   => $user->phone,
                'address' => $user->address,
                'status'  => 'pending',   // default status
            ]);
        }

        // ekhono tumi login page e pathaccho (iche hole auto-login o korte paro)
        return redirect()->route('login')->with('success', 'Registration successful!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ]);
    }

    // 🔥 Final role-based dashboard
    public function dashboard()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'donor':
                return redirect()->route('donor.dashboard');

            case 'organization':
                return redirect()->route('ngo.dashboard');

            case 'admin':
                return redirect()->route('admin.dashboard');

            default:
                return redirect()->route('home');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
