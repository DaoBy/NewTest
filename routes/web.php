<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\CollectorDashboardController;
use App\Http\Controllers\Dashboard\CustomerDashboardController;
use App\Http\Controllers\Dashboard\DriverDashboardController;
use App\Http\Controllers\Dashboard\StaffDashboardController;
use App\Http\Controllers\PriceMatrixController;
use App\Http\Controllers\RequestDeliveryController;
use App\Http\Controllers\AddressBookController;
use App\Http\Controllers\TransactionHistoryController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//  Public Routes (Open for Everyone)
Route::get('/', fn() => Inertia::render('Customer/Home'))->name('customer.home');
Route::get('/tracking', fn() => Inertia::render('Customer/Tracking'))->name('tracking');
Route::get('/about-us', fn() => Inertia::render('Customer/AboutUs'))->name('about.us');
Route::get('/services', fn() => Inertia::render('Customer/Services'))->name('services');
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact.us');
Route::post('/contact-us', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/price-matrix', [PriceMatrixController::class, 'index']);
Route::get('/employee', fn() => Inertia::render('Auth/EmployeeLanding'))->name('employee.landing');

// Walk-in Customer Route
Route::post('/walkin/store', [RegisteredUserController::class, 'storeWalkIn'])->name('walkin.store');

// Customer Routes (Authenticated: 'customer' Role)
Route::middleware(['auth', 'role:customer'])->group(function () {
    // Address Book
    Route::get('/address-book', [AddressBookController::class, 'index'])->name('address.book');
    Route::post('/address-book', [AddressBookController::class, 'store'])->name('address.book.store');
    Route::put('/address-book/{id}', [AddressBookController::class, 'update'])->name('address.book.update');
    Route::delete('/address-book/{id}', [AddressBookController::class, 'destroy'])->name('address.book.destroy');
    
    // Transaction History
    Route::get('/transaction-history', [TransactionHistoryController::class, 'index'])->name('transaction.history');
    
    // Request Delivery
    Route::get('/request-delivery', fn() => inertia('Customer/RequestDelivery'))->name('request.delivery');
    Route::post('/request-delivery', [RequestDeliveryController::class, 'store'])->name('request.delivery.store');
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Employee Routes (Authenticated by Role) // Sign in Palang gumagana redirect sa dashboard. These pages are just placeholders.

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', fn () => Inertia::render('Admin/AdminDash'))->name('admin.dashboard');
    Route::get('/employees', fn () => Inertia::render('Admin/EmpManagement'))->name('admin.employees');
    Route::get('/customers', fn () => Inertia::render('Admin/CusManagement'))->name('admin.customers');
    Route::get('/trucks', fn () => Inertia::render('Admin/TruckManagement'))->name('admin.trucks');
    Route::get('/regions', fn () => Inertia::render('Admin/RegionManagement'))->name('admin.regions');
    Route::get('/items', fn () => Inertia::render('Admin/Items'))->name('admin.ItemManagement');
    Route::get('/cargo-assignments', fn () => Inertia::render('Admin/CargoAssign'))->name('admin.cargo-assignments');
    Route::get('/package-tracking', fn () => Inertia::render('Admin/PackageTrack'))->name('admin.package-tracking');
    Route::get('/driver-monitoring', fn () => Inertia::render('Admin/DriverMonitor'))->name('admin.driver-monitoring');
    Route::get('/billing', fn () => Inertia::render('Admin/Billing'))->name('admin.billing');
    Route::get('/payment-management', fn () => Inertia::render('Admin/PaymentManagement'))->name('admin.payment-management');
    Route::get('/payment-status', fn () => Inertia::render('Admin/PaymentStatus'))->name('admin.payment-status');
    Route::get('/waybill-download', fn () => Inertia::render('Admin/WaybillDownload'))->name('admin.waybill-download');
    Route::get('/truck-manifests', fn () => Inertia::render('Admin/TruckManifests'))->name('admin.truck-manifests');
    Route::get('/backup-restore', fn () => Inertia::render('Admin/BackupRestore'))->name('admin.backup-restore');
    Route::get('/archive', fn () => Inertia::render('Admin/Archive'))->name('admin.archive');
    Route::get('/settings', fn () => Inertia::render('Admin/Settings'))->name('admin.settings');
    Route::get('/transaction-history', fn () => Inertia::render('TransacHistory'))->name('admin.transaction-history');
});

// Staff Routes
Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/staff/dashboard', [StaffDashboardController::class, 'index'])->name('staff.dashboard');
});

// Driver Routes
Route::middleware(['auth', 'role:driver'])->group(function () {
    Route::get('/driver/dashboard', [DriverDashboardController::class, 'index'])->name('driver.dashboard');
});

// Collector Routes
Route::middleware(['auth', 'role:collector'])->group(function () {
    Route::get('/collector/dashboard', [CollectorDashboardController::class, 'index'])->name('collector.dashboard');
});

require __DIR__.'/auth.php';
