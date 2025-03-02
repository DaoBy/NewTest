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





Route::get('/employee', fn() => Inertia::render('Auth/EmployeeLanding'))->name('employee.landing');




// Dashboard routes for specific employee roles
Route::middleware(['auth', 'role:admin'])->group(function () {

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


// Role Select
Route::get('/dashboard', fn () => Inertia::render('Shared/RoleSelect'))->name('role.select');




// TEST Admin Routes
Route::prefix('admin')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', fn () => Inertia::render('Admin/AdminDash'))->name('admin.dashboard');

    // Employee Management
    Route::get('/employees', fn () => Inertia::render('Admin/EmpManagement'))->name('admin.employees');

    // Customer Management
    Route::get('/customers', fn () => Inertia::render('Admin/CusManagement'))->name('admin.customers');

    // Truck Management
    Route::get('/trucks', fn () => Inertia::render('Admin/TruckManagement'))->name('admin.trucks');

    // Region/Area Management
    Route::get('/regions', fn () => Inertia::render('Admin/RegionManagement'))->name('admin.regions');

    // Item Management
    Route::get('/items', fn () => Inertia::render('Admin/Items'))->name('admin.ItemManagement');

    // Cargo Assignment
    Route::get('/cargo-assignments', fn () => Inertia::render('Admin/CargoAssign'))->name('admin.cargo-assignments');

    // Package Tracking
    Route::get('/package-tracking', fn () => Inertia::render('Admin/PackageTrack'))->name('admin.package-tracking');

    // Driver Monitoring
    Route::get('/driver-monitoring', fn () => Inertia::render('Admin/DriverMonitor'))->name('admin.driver-monitoring');

    // Billing
    Route::get('/billing', fn () => Inertia::render('Admin/Billing'))->name('admin.billing');

    // Payment Management
    Route::get('/payment-management', fn () => Inertia::render('Admin/PaymentManagement'))->name('admin.payment-management');

    // Payment Status
    Route::get('/payment-status', fn () => Inertia::render('Admin/PaymentStatus'))->name('admin.payment-status');

    // Waybill Download
    Route::get('/waybill-download', fn () => Inertia::render('Admin/WaybillDownload'))->name('admin.waybill-download');

    // Truck Manifest
    Route::get('/truck-manifests', fn () => Inertia::render('Admin/TruckManifests'))->name('admin.truck-manifests');

    // Backup & Restore
    Route::get('/backup-restore', fn () => Inertia::render('Admin/BackupRestore'))->name('admin.backup-restore');

    // Archive
    Route::get('/archive', fn () => Inertia::render('Admin/Archive'))->name('admin.archive');

    // Settings
    Route::get('/settings', fn () => Inertia::render('Admin/Settings'))->name('admin.settings');

    // Transaction History
    Route::get('/transaction-history', fn () => Inertia::render('TransacHistory'))->name('admin.transaction-history');

    // Delivery Requests
    Route::get('/delivery-requests', fn () => Inertia::render('Admin/DeliveryRequests'))->name('admin.delivery-requests');


});




require __DIR__.'/auth.php';
