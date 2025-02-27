<?php
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\CollectorDashboardController;
use App\Http\Controllers\Dashboard\CustomerDashboardController;
use App\Http\Controllers\Dashboard\DriverDashboardController;
use App\Http\Controllers\Dashboard\StaffDashboardController;

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', fn() => Inertia::render('Customer/Home'))->name('customer.home');

//Tracking
Route::get('/tracking', function () {
    return Inertia::render('Customer/Tracking');
})->name('tracking');

//Delivery Request
Route::get('/request', function () {
    return Inertia::render('Customer/RequestDelivery');
})->name('request.delivery');



// Customer Dashboard (default role: customer)
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
});

// Dashboard routes for specific employee roles
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/staff/dashboard', [StaffDashboardController::class, 'index'])->name('staff.dashboard');
});

Route::middleware(['auth', 'role:driver'])->group(function () {
    Route::get('/driver/dashboard', [DriverDashboardController::class, 'index'])->name('driver.dashboard');
});

Route::middleware(['auth', 'role:collector'])->group(function () {
    Route::get('/collector/dashboard', [CollectorDashboardController::class, 'index'])->name('collector.dashboard');
});


Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
