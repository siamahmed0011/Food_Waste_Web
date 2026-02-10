<?php

namespace App\Http\Controllers;

use App\Models\PickupRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NgoOrderController extends Controller
{
    public function index(Request $request)
    {
        $ngoId = Auth::id();
        $status = $request->query('status');

        $q = PickupRequest::with(['foodPost', 'donor'])
            ->where('ngo_user_id', $ngoId)
            ->latest();

        if ($status) {
            $q->where('status', $status);
        }

        $orders = $q->paginate(10)->withQueryString();

        return view('pages.ngos.orders', compact('orders', 'status'));
    }

    public function updateStatus(Request $request, PickupRequest $order)
    {
        // If you want NGO to update status, handle here (optional)
        return back()->with('success', 'Status updated.');
    }

    public function cancel(PickupRequest $pickupRequest)
    {
        if ($pickupRequest->ngo_user_id !== Auth::id()) {
            abort(403);
        }

        if ($pickupRequest->status !== 'pending') {
            return back()->with('error', 'Only pending requests can be cancelled.');
        }

        $pickupRequest->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return back()->with('success', 'Request cancelled.');
    }
}
