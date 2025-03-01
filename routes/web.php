<?php
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\CollectorDashboardController;
use App\Http\Controllers\Dashboard\CustomerDashboardController;
use App\Http\Controllers\Dashboard\DriverDashboardController;
use App\Http\Controllers\Dashboard\StaffDashboardController;
use App\Http\Controllers\RequestDeliveryController;
use App\Http\Controllers\AddressBookController;
use App\Http\Controllers\TransactionHistoryController;

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', fn() => Inertia::render('Customer/Home'))->name('customer.home');



Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/request-delivery', [RequestDeliveryController::class, 'create'])->name('request.delivery');
    Route::post('/request-delivery', [RequestDeliveryController::class, 'store'])->name('delivery.store');
    Route::get('/address-book', [AddressBookController::class, 'index'])->name('address.book');
    Route::post('/address-book', [AddressBookController::class, 'store'])->name('address.book.store');
    Route::put('/address-book/{id}', [AddressBookController::class, 'update'])->name('address.book.update');
    Route::delete('/address-book/{id}', [AddressBookController::class, 'destroy'])->name('address.book.destroy');

    // Transaction History Routes
    Route::get('/transaction-history', [TransactionHistoryController::class, 'index'])->name('transaction.history');
});


Route::get('/tracking', fn() => Inertia::render('Customer/Tracking'))->name('tracking');
Route::get('/about-us', fn() => Inertia::render('Customer/AboutUs'))->name('about.us');
Route::get('/services', fn() => Inertia::render('Customer/Services'))->name('services');
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact.us');
Route::post('/contact-us', [ContactController::class, 'submit'])->name('contact.submit');


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
