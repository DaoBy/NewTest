<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the customer registration view.
     */
    public function createCustomer(): Response
    {
        return Inertia::render('Auth/CustomerRegister');
    }

    /**
     * Display the employee registration view.
     */
    public function createEmployee(): Response
    {
        return Inertia::render('Auth/EmployeeRegister');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password'      => ['required', 'confirmed', Rules\Password::defaults()],
            'role'          => 'nullable|in:customer,admin,collector,staff,driver',
            'mobile'  => 'nullable|string|max:20',
            'name'     => 'required_if:role,customer|string|max:255',
            'street'        => 'nullable|string|max:255',
            'city'          => 'nullable|string|max:100',
            'province'      => 'nullable|string|max:100',
            'zip_code'      => 'nullable|string|max:20',
            'company_name'  => 'nullable|string|max:255',
            'customer_type' => 'nullable|in:individual,corporate',
        ]);

        // Set default role to 'customer' if not provided
        $role = $request->input('role', 'customer');

        // Create the user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $role,
        ]);

        // If the user is a customer, create a corresponding customer record
        if ($role === 'customer' && !$user->customer) {
            Customer::create([
                'user_id'       => $user->id,
                'name'     => $request->name,
                'mobile'  => $request->mobile,
                'street'        => $request->street,
                'city'          => $request->city,
                'province'      => $request->province,
                'zip_code'      => $request->zip_code,
                'company_name'  => $request->company_name,
                'customer_type' => $request->customer_type ?? 'individual',
                'is_system'     => false, // Ensure it's NOT a walk-in
            ]);
        }

        event(new Registered($user));
        Auth::login($user);

        // Redirect based on role
        return match ($user->role) {
            'customer' => redirect()->route('customer.home'),
            'admin'    => redirect()->route('admin.dashboard'),
            'staff'    => redirect()->route('staff.dashboard'),
            'driver'   => redirect()->route('driver.dashboard'),
            'collector'=> redirect()->route('collector.dashboard'),
        };
    }

/**
 * Handle walk-in customer creation.
 */
public function storeWalkIn(Request $request): RedirectResponse
{
    $request->validate([
        'name'     => 'required|string|max:255',
        'mobiler'  => 'nullable|string|max:20',
        'email'         => 'nullable|email|max:255',
        'street'        => 'nullable|string|max:255',
        'city'          => 'nullable|string|max:100',
        'province'      => 'nullable|string|max:100',
        'zip_code'      => 'nullable|string|max:20',
        'company_name'  => 'nullable|string|max:255',
        'customer_type' => 'nullable|in:individual,corporate',
    ]);

    // Create the walk-in customer (user_id = null and is_system = true)
    $customer = Customer::create([
        'user_id'       => null, // No linked user for walk-ins
        'name'           => $request->name,
        'mobile'         => $request->mobile,
        'email'         => $request->email,
        'street'        => $request->street,
        'city'          => $request->city,
        'province'      => $request->province,
        'zip_code'      => $request->zip_code,
        'company_name'  => $request->company_name,
        'customer_type' => $request->customer_type ?? 'individual',
        'is_system'     => true, // Mark as walk-in
    ]);

    return redirect()->route('staff.dashboard')->with('success', 'Walk-in customer created successfully!');
}

}
