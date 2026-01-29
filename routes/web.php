<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Donor\DashboardController as DonorDashboardController;
use App\Http\Controllers\Donor\FoodPostController;
use App\Http\Controllers\Donor\PickupController;
use App\Http\Controllers\Donor\ProfileController;
use App\Http\Controllers\Donor\NgoBrowseController;
use App\Http\Controllers\NgoController;
use App\Http\Controllers\NgoOrderController;
use App\Http\Controllers\Ngo\NgoFoodController;
use App\Http\Controllers\Admin\AdminFoodController;


// ====================== PUBLIC ROUTES ======================

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/signup', function () {
    return view('pages.register');
})->name('signup.choice');

Route::get('/register/donor', [AuthController::class, 'showDonorRegisterForm'])
    ->name('register.donor');

Route::get('/register/organization', [AuthController::class, 'showOrganizationRegisterForm'])
    ->name('register.organization');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.post');

Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/dashboard', [AuthController::class, 'dashboard'])
    ->middleware('auth')
    ->name('dashboard');


// ====================== ADMIN ROUTES ======================

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');
    });



// ====================== DONOR ROUTES ======================

Route::middleware('auth')
    ->prefix('donor')
    ->name('donor.')
    ->group(function () {

        // Donor dashboard
        Route::get('/dashboard', [DonorDashboardController::class, 'index'])
            ->name('dashboard');

        // Post new food
        Route::get('/food/create', [FoodPostController::class, 'create'])
            ->name('food.create');

        Route::post('/food', [FoodPostController::class, 'store'])
            ->name('food.store');

        // My donations list
        Route::get('/donations', [FoodPostController::class, 'myDonations'])
            ->name('donations');

        // Single donation details page
        Route::get('/food/{post}', [FoodPostController::class, 'show'])
            ->name('food.show');

        // Update status (Available / Completed / Cancelled ...)
        Route::patch('/food/{post}/status', [FoodPostController::class, 'updateStatus'])
            ->name('food.updateStatus');

        // Edit + Update + Delete
        Route::get('/food/{post}/edit', [FoodPostController::class, 'edit'])
            ->name('food.edit');
        Route::put('/food/{post}', [FoodPostController::class, 'update'])
            ->name('food.update');
        Route::delete('/food/{post}', [FoodPostController::class, 'destroy'])
            ->name('food.destroy');

        // ------- DONOR PROFILE ROUTES -------
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('/profile/password', [ProfileController::class, 'passwordForm'])->name('profile.password');
        Route::post('/profile/password/update', [ProfileController::class, 'updatePassword'])
            ->name('profile.password.update');

        // Donor: Browse NGO List
        Route::get('/ngos', [NgoBrowseController::class, 'index'])
            ->name('ngos.index');


        // ================== PICKUP MODULE (BACKEND) ==================

        // Show pickup form   GET /donor/pickups/create
        Route::get('/pickups/create', [PickupController::class, 'create'])
            ->name('pickups.create');

        // Store pickup form  POST /donor/pickups
        Route::post('/pickups', [PickupController::class, 'store'])
            ->name('pickups.store');

        // List pickups       GET /donor/pickups
        Route::get('/pickups', [PickupController::class, 'index'])
            ->name('pickups.index');
    });



// ====================== NGO ROUTES ======================

// ====================== NGO ROUTES ======================
Route::prefix('ngo')->name('ngo.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [NgoController::class, 'index'])->name('dashboard');

    Route::view('/profile', 'pages.ngos.profile')->name('profile');

    Route::get('/orders', [NgoOrderController::class, 'index'])->name('orders');
    Route::patch('/orders/{order}/status', [NgoOrderController::class, 'updateStatus'])
        ->name('orders.updateStatus');

    Route::view('/settings', 'pages.ngos.settings')->name('settings');
    Route::post('/settings', [NgoController::class, 'updateSettings'])->name('settings.update');

    Route::get('/all-ngos', [NgoController::class, 'allNgos'])->name('all_ngos');
    Route::get('/donors', [NgoController::class, 'donors'])->name('donors');

    // ✅ Available Foods (NGO)
    Route::get('/available-foods', [NgoFoodController::class, 'index'])->name('available_foods');
});

Route::prefix('ngo')->name('ngo.')->middleware(['auth'])->group(function () {

    Route::get('/available-foods', [NgoFoodController::class, 'index'])->name('available_foods');

    // ✅ food details
    Route::get('/food/{foodPost}', [NgoFoodController::class, 'show'])->name('food.show');

    // ✅ accept/request pickup
    Route::post('/food/{foodPost}/accept', [NgoFoodController::class, 'accept'])->name('food.accept');
});

Route::prefix('ngo')->name('ngo.')->middleware(['auth'])->group(function () {
    Route::get('/available-foods', [NgoFoodController::class, 'index'])->name('available_foods');

    // ✅ Food details page
    Route::get('/food/{foodPost}', [NgoFoodController::class, 'show'])->name('food.show');
});