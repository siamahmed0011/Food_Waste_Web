<?php
namespace App\Http\Controllers\Ngo;

use App\Http\Controllers\Controller;
use App\Models\FoodPost;

class NgoFoodController extends Controller
{
    public function index()
    {
        $foods = FoodPost::where('status', 'available')
            ->latest()
            ->paginate(10);

        return view('pages.ngos.available_foods', compact('foods'));
    }

      public function show(FoodPost $foodPost)
{
    return view('pages.ngos.food_show', ['food' => $foodPost]);
}

 public function accept(FoodPost $foodPost)
 {
    // Already accepted হলে আবার accept না
    if ($foodPost->status !== 'available') {
        return back()->with('error', 'This food is not available anymore.');
    }

    $foodPost->update([
        'status' => 'accepted',
    ]);

    return back()->with('success', 'Food accepted successfully!');
 }


}
