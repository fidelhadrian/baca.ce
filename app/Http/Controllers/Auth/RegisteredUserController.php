<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate incoming request data
        $request->validate([
            'personal_id' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    
        // Check if a user already exists with the same personal_id (NIM/NIP)
        if (User::where('personal_id', $request->personal_id)->exists()) {
            // Redirect back with error messages
            return redirect()->back()->withErrors([
                'personal_id' => 'User with this Personal ID already exists.',
            ])->withInput();
        }
    
        // Create a new user
        $user = User::create([
            'personal_id' => $request->personal_id,
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'role_id' => 3, // Default to 'student' role
        ]);
    
        // Event registration and login
        event(new Registered($user));
        Auth::login($user);
    
        // Redirect to home/dashboard
        return redirect(RouteServiceProvider::HOME);
    }      
}
