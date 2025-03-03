<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // Role-specific redirect logic
        return match ($user->role) {
            'customer'  => redirect()->intended(route('customer.home')),
            'admin'     => redirect()->intended(route('admin.dashboard')),
            'staff'     => redirect()->intended(route('staff.dashboard')),
            'driver'    => redirect()->intended(route('driver.dashboard')),
            'collector' => redirect()->intended(route('collector.dashboard')),
            default     => redirect()->intended(route('dashboard')), // Fallback (Optional)
        };
    }

    /**
     * Destroy an authenticated session (Logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user(); // Capture user before logout
    
        Auth::guard('web')->logout();
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        // Redirect based on role after logout
        return match ($user?->role) {
            'customer'  => redirect('/'),
            'admin', 'staff', 'driver', 'collector' => redirect()->route('employee.landing'),
            default     => redirect('/'), // Fallback for any unknown roles
        };
    }
}

