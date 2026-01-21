<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use App\Models\FoodPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodPostController extends Controller
{
    // ================== CREATE FOOD FORM ==================
   public function create()
{
    $user = Auth::user();
    $post = null;   // important: form er jonno always thakbe

    return view('pages.donor.food_create', compact('user', 'post'));
}


    // ================== STORE FOOD POST ==================
    public function store(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'title'             => 'required|string|max:255',
            'category'          => 'nullable|string|max:100',
            'quantity'          => 'nullable|integer|min:1',
            'unit'              => 'nullable|string|max:50',
            'cooked_at'         => 'nullable|date',
            'expiry_time'       => 'nullable|date|after_or_equal:cooked_at',
            'pickup_time_from'  => 'nullable|date',
            'pickup_time_to'    => 'nullable|date|after_or_equal:pickup_time_from',
            'pickup_address'    => 'nullable|string|max:255',
            'description'       => 'nullable|string',
            'image_path'        => 'nullable|image|max:2048',
        ]);

        $data['user_id'] = $user->id;

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request
                ->file('image_path')
                ->store('food_images', 'public');
        }

        FoodPost::create($data);

        return redirect()
            ->route('donor.dashboard')
            ->with('success', 'Food posted successfully!');
    }

    // ================== MY DONATIONS LIST (with search + filter) ==================
    public function myDonations(Request $request)
    {
        $user = Auth::user();

        // query parameter theke search & status nei
        $searchTerm   = $request->query('q');       // title search
        $filterStatus = $request->query('status');  // available/completed/cancelled...

        // stats er jonno (filter chara)
        $statsQuery = FoodPost::where('user_id', $user->id)->get();
        $totalPosts     = $statsQuery->count();
        $availableCount = $statsQuery->where('status', 'available')->count();
        $completedCount = $statsQuery->where('status', 'completed')->count();

        // main list filtering er jonno query
        $query = FoodPost::where('user_id', $user->id);

        // status filter
        if ($filterStatus && in_array($filterStatus, ['available', 'reserved', 'completed', 'cancelled'])) {
            $query->where('status', $filterStatus);
        }

        // search filter (title er opor)
        if (!empty($searchTerm)) {
            $query->where('title', 'like', '%' . $searchTerm . '%');
        }

        // final list
        $posts = $query->orderBy('created_at', 'desc')->get();

        return view('pages.donor.donations', [
            'user'            => $user,
            'posts'           => $posts,
            'totalPosts'      => $totalPosts,
            'availableCount'  => $availableCount,
            'completedCount'  => $completedCount,
            'searchTerm'      => $searchTerm,
            'filterStatus'    => $filterStatus,
        ]);
    }



    
  // ================== EDIT FORM ==================
public function edit(FoodPost $post)
{
    // Own post check
    if ($post->user_id !== Auth::id()) {
        abort(403);
    }

    $user = Auth::user();

    // create form reuse korbo, tai just $post dicchi
    return view('pages.donor.food_create', compact('user', 'post'));
}

   // ================== UPDATE EXISTING POST ==================
public function update(Request $request, FoodPost $post)
{
    if ($post->user_id !== Auth::id()) {
        abort(403);
    }

    $data = $request->validate([
        'title'             => 'required|string|max:255',
        'category'          => 'nullable|string|max:100',
        'quantity'          => 'nullable|integer|min:1',
        'unit'              => 'nullable|string|max:50',
        'cooked_at'         => 'nullable|date',
        'expiry_time'       => 'nullable|date|after_or_equal:cooked_at',
        'pickup_time_from'  => 'nullable|date',
        'pickup_time_to'    => 'nullable|date|after_or_equal:pickup_time_from',
        'pickup_address'    => 'nullable|string|max:255',
        'description'       => 'nullable|string',
        'image_path'        => 'nullable|image|max:2048',
    ]);

    // image dile replace korbe
    if ($request->hasFile('image_path')) {
        $data['image_path'] = $request
            ->file('image_path')
            ->store('food_images', 'public');
    }

    $post->update($data);

    return redirect()
        ->route('donor.food.show', $post->id)
        ->with('success', 'Food post updated successfully!');
}

    // ================== DELETE / CANCEL POST ==================
public function destroy(FoodPost $post)
{
    if ($post->user_id !== Auth::id()) {
        abort(403);
    }

    $post->delete();

    return redirect()
        ->route('donor.donations')
        ->with('success', 'Food post deleted successfully.');
}
    // ================== SINGLE DONATION DETAILS ==================
    public function show(FoodPost $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        return view('pages.donor.food_show', [
            'user' => Auth::user(),
            'post' => $post,
        ]);
    }

    // ================== UPDATE STATUS (Available / Completed / Cancelled) ==================
    public function updateStatus(Request $request, FoodPost $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:available,reserved,completed,cancelled',
        ]);

        $post->status = $validated['status'];
        $post->save();

        return back()->with('success', 'Donation status updated successfully.');
    }
}
