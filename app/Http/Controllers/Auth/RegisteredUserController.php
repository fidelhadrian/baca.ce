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
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the personal_id (NIM) and password fields
        $request->validate([
            'personal_id' => ['required', 'string', 'exists:students,nim'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    
        // Retrieve student data based on the personal_id (NIM)
        $student = Student::where('nim', $request->personal_id)->first();
    
        // If student not found, redirect back with error message
        if (!$student) {
            return redirect()->back()->withErrors([
                'personal_id' => 'Student with this NIM does not exist.',
            ])->withInput();
        }

        // Check if the user already exists
        if (User::where('personal_id', $request->personal_id)->exists()) {
            return redirect()->back()->withErrors([
                'personal_id' => 'User with this NIM already exists.',
            ])->withInput();
        }

        // Create the new user, automatically setting the 'student' role (role_id = 3)
        $user = User::create([
            'personal_id' => $request->personal_id,
            'name' => $student->name,  // Use the name from the students table
            'password' => Hash::make($request->password),
            'role_id' => 3,  // Set default role to student
        ]);
    
        // Trigger the Registered event and log the user in
        event(new Registered($user));
        Auth::login($user);
    
        // Redirect to home or dashboard after successful registration
        return redirect(RouteServiceProvider::HOME);
    }
}
