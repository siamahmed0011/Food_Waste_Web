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
Route::get('/ngos', [NgoController::class, 'publicList'])->name('ngos.public');


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

        Route::get('/dashboard', [DonorDashboardController::class, 'index'])->name('dashboard');

        Route::get('/food/create', [FoodPostController::class, 'create'])->name('food.create');
        Route::post('/food', [FoodPostController::class, 'store'])->name('food.store');

        Route::get('/donations', [FoodPostController::class, 'myDonations'])->name('donations');
        Route::get('/food/{post}', [FoodPostController::class, 'show'])->name('food.show');

        Route::patch('/food/{post}/status', [FoodPostController::class, 'updateStatus'])->name('food.updateStatus');

        Route::get('/food/{post}/edit', [FoodPostController::class, 'edit'])->name('food.edit');
        Route::put('/food/{post}', [FoodPostController::class, 'update'])->name('food.update');
        Route::delete('/food/{post}', [FoodPostController::class, 'destroy'])->name('food.destroy');

        // Donor profile
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('/profile/password', [ProfileController::class, 'passwordForm'])->name('profile.password');
        Route::post('/profile/password/update', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

        // Browse NGOs
        Route::get('/ngos', [NgoBrowseController::class, 'index'])->name('ngos.index');

        // Donor can view NGO profile
        Route::get('/ngo/{user}', [ProfileController::class, 'showNgo'])->name('ngo.show');

        // Pickups (INCOMING requests from NGOs)
        Route::get('/pickups', [PickupController::class, 'index'])->name('pickups.index');
        Route::get('/pickups/create', [PickupController::class, 'create'])->name('pickups.create');
        Route::post('/pickups', [PickupController::class, 'store'])->name('pickups.store');

        Route::post('/pickups/{pickup}/approve', [PickupController::class, 'approve'])->name('pickups.approve');
        Route::post('/pickups/{pickup}/reject', [PickupController::class, 'reject'])->name('pickups.reject');
        Route::post('/pickups/{pickup}/picked-up', [PickupController::class, 'pickedUp'])->name('pickups.pickedup');
        Route::post('/pickups/{pickup}/complete', [PickupController::class, 'complete'])->name('pickups.complete');
    });

// ====================== NGO ROUTES ======================
    Route::prefix('ngo')->name('ngo.')->middleware('auth')->group(function () {

    Route::get('/dashboard', [NgoController::class, 'index'])->name('dashboard');

    Route::view('/profile', 'pages.ngos.profile')->name('profile');
    Route::view('/settings', 'pages.ngos.settings')->name('settings');
    Route::post('/settings', [NgoController::class, 'updateSettings'])->name('settings.update');

    Route::get('/orders', [NgoOrderController::class, 'index'])->name('orders');
    Route::patch('/orders/{order}/status', [NgoOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('/orders/{pickupRequest}/cancel', [NgoOrderController::class, 'cancel'])->name('orders.cancel');

    Route::get('/available-foods', [NgoFoodController::class, 'index'])->name('available_foods');
    Route::get('/food/{foodPost}', [NgoFoodController::class, 'show'])->name('food.show');
    Route::post('/food/{foodPost}/accept', [NgoFoodController::class, 'accept'])->name('food.accept');

    Route::get('/all-ngos', [NgoController::class, 'allNgos'])->name('all_ngos');
    Route::get('/donors', [NgoController::class, 'donors'])->name('donors');

    // ✅ NGO can view donor profile (NO double /ngo)
    Route::get('/donor/{user}', [NgoController::class, 'showDonor'])->name('donor.show');
});