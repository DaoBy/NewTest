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
        'email'         => 'required|string|lowercase|email|max:255|unique:'.User::class,
        'password'      => ['required', 'confirmed', Rules\Password::defaults()],
        'role'          => 'nullable|in:customer,admin,collector,staff,driver',
        'phone_number'  => 'nullable|string|max:20',
        'address'       => 'nullable|string|max:255',
        'birth_date'    => 'nullable|date',
        'gender'        => 'nullable|in:male,female,other',
        'company_name'  => 'nullable|string|max:255',
        'national_id'   => 'nullable|string|max:50',
        'customer_type' => 'nullable|in:individual,corporate',
    ]);

    // Set default role to 'customer' if no role is provided
    $role = $request->input('role', 'customer');

    // Create the user
    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'role'     => $role,
    ]);

    // If the user is a customer, create a corresponding customer record
    if ($role === 'customer') {
        Customer::create([
            'user_id'       => $user->id,
            'phone_number'  => $request->phone_number,
            'address'       => $request->address,
            'birth_date'    => $request->birth_date,
            'gender'        => $request->gender,
            'company_name'  => $request->company_name,
            'national_id'   => $request->national_id,
            'customer_type' => $request->customer_type ?? 'individual',
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
}