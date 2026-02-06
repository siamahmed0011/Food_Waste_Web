<?php

namespace App\Http\Controllers;

use App\Models\PickupRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NgoOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ✅ NGO: My Requests list
    public function index(Request $request)
    {
        $userId = Auth::id();
        $status = $request->query('status'); // optional filter

        $query = PickupRequest::with(['foodPost', 'donor'])
            ->where('ngo_user_id', $userId)
            ->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query->paginate(15);

        return view('pages.ngos.orders', compact('orders', 'status'));
    }

    // ✅ NGO can cancel ONLY pending request
    public function cancel(PickupRequest $pickupRequest)
    {
        if ((int)$pickupRequest->ngo_user_id !== (int)Auth::id()) {
            abort(403);
        }

        if ($pickupRequest->status !== 'pending') {
            return back()->with('error', 'Only pending requests can be cancelled.');
        }

        $pickupRequest->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return back()->with('success', 'Request cancelled successfully.');
    }
}
