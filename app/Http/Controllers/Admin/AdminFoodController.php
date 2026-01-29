<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoodPost;

class AdminFoodController extends Controller
{
    public function index()
    {
        $foods = FoodPost::where('status', 'available')
            ->latest()
            ->paginate(15);

        return view('pages.admin.available_foods', compact('foods'));
    }
}
