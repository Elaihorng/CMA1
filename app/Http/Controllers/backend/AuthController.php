<?php

namespace App\Http\Controllers\backend;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use App\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function index()
    {
        return view('backend.auth.login');
    }

    public function register()
    {
        return view('backend.auth.register');
    }
    public function forget()
    {
        return view('backend.auth.forget');
    }

    public function showOtpForm()
    {
        return view('backend.auth.verify-otp');
    }
    public function resendOtp(Request $request)
    {
        // Get registration data from session
        $registrationData = session('registration_data');
    
        if (!$registrationData || !isset($registrationData['email'])) {
            return redirect()->back()->with('error', 'User session expired. Please register again.');
        }
    
        // Generate new OTP
        $otp = rand(100000, 999999);
    
        // Update OTP in session
        $registrationData['otp'] = $otp;
        session(['registration_data' => $registrationData]);
    
        // Log for debug
        \Log::info("New OTP generated for {$registrationData['email']}: $otp");
    
        // Resend OTP
        Mail::to($registrationData['email'])->send(new SendOtpMail($otp));
    
        return back()->with('success', 'A new OTP has been sent to your email.');
    }
    
    
    

    public function saveRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);
    
        $otp = rand(100000, 999999);
    
        $registrationData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,  // Store raw password
            'otp' => $otp,
        ];
        session(['registration_data' => $registrationData]);
    
        Mail::to($validated['email'])->send(new SendOtpMail($otp));
    
        return redirect()->route('otp.form')->with('success', 'Check your email for the OTP.');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);
    
        $data = session('registration_data');
    
        if (!$data || $data['otp'] != $request->otp) {
            return back()->with('error', 'Invalid or expired OTP.');
        }
        // $hashedPassword = Hash::make($data['password']);
        // Save user to DB (ensure password is hashed)
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'], // Ensure this is a hashed password from saveRegister
            'otp' => $data['otp'],
            'otp_verified_at' => now(),
        ]);
    
        // Attach role
        $customerRole = Role::where('name', 'customer')->first();
        if ($customerRole) {
            $user->roles()->attach($customerRole->id);
        } 
    
        // Clear OTP session
        session()->forget('registration_data');
    
        // Log in user
        Auth::login($user);
        $request->session()->regenerate();
    
        session(['username' => $user->name]);
    
        return redirect('/')->with('success', 'OTP Verified! Account created and you are now logged in.');
    }

    public function loginAction(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // Use only email and password to attempt login
        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }
    
        $user = Auth::user();
    
        // Check if OTP was verified
        // if (!$user->otp_verified_at) {
        //     Auth::logout();
        //     return redirect()->route('login')->with('error', 'Please verify your email via OTP before logging in.');
        // }
    
        $request->session()->regenerate();
    
        session(['username' => $user->name]);
    
        $role = $user->roles->first();
        // dd(session()->all());
        if ($role && $role->name == 'admin') {
            return redirect()->route('dashboard.index')->with('success', 'Welcome to the admin dashboard!');
        } elseif ($role && $role->name == 'customer') {
            return redirect('/')->with('success', 'Welcome to the customer home page!');
        }
        
        return redirect()->route('login')->withErrors('Role not found!');
    }

    public function showUsers()
    {
        $users = User::all(); // you can use paginate(10) if needed
        return view('backend.user.index', compact('users'));
    }
    public function createUser(Request $request)
    {
        // Add validation for creating a new user
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role' => 'required|exists:roles,name', // Role must exist in the roles table
        ]);

        // Hash the password before storing it
        $password = Hash::make($validated['password']);

        // Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $password,
        ]);

        // Attach the selected role
        $role = Role::where('name', $validated['role'])->first();
        $user->roles()->attach($role);

        // Redirect or return with success message
        return redirect()->route('index')->with('success', 'User created successfully!');
    }
    public function createUserForm()
    {
        $roles = Role::all(); // Get all roles to display in the dropdown
        return view('backend.user.create', compact('roles'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all(); // 
        return view('backend.user.edit', compact('user','roles'));
    }

    public function handleForget(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);
    
        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
    
    public function showResetForm($token)
    {
        return view('backend.auth.recover', ['token' => $token]);
    }
    public function submitReset(Request $request)
    {
        // Log the incoming request data for debugging
        Log::info('Password Reset Request:', $request->all());
    
        // Validate the form data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required', // Make sure password is valid
            'token' => 'required',
        ]);
    
        // Attempt to reset the password
        $status = Password::reset(
            $request->only('email', 'password', 'token'),
            function ($user, $password) {
                // Update the user's password
                $user->password = $password;
                $user->save();
            }
        );
    
        // Log the reset status for debugging
        Log::info('Password Reset Status', ['status' => $status]);
    
        // Check if the password was successfully reset
        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Password has been reset successfully!');
        } else {
            return back()->withErrors(['email' => 'Failed to reset password.']);
        }
    }
    
    
    
    
    
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $id.',user_id', // Ensure unique email for the user
            'password' => 'nullable|min:8|confirmed', // If provided, must match the confirmation
            'role' => 'required|exists:roles,name', // Role must exist in the roles table
        ]);
    
        // Find the user by ID
        $user = User::findOrFail($id);
    
        // If password is provided, hash it and update the password
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
            $user->password = $validated['password'];  // Update the password
        }
    
        // Update the user's name and email
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);
    
        // Find the role based on the name
        $role = Role::where('name', $validated['role'])->first();
    
        // Ensure the role exists before proceeding
        if ($role) {
            // If the role has changed, detach previous roles and attach the new one
            if ($user->roles->first()->name !== $validated['role']) {
                $user->roles()->detach();
                $user->roles()->attach($role);
            }
        } else {
            return back()->withErrors('Role not found!');
        }
    
        // Redirect back to the edit page with a success message
        return redirect()->route('user.edit', $user->user_id)->with('alert_message', 'User updated successfully!');
    }


    public function destroy(string $id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Optionally, handle related model clean-up (e.g., delete associated files, etc.)
        // For example, if your user model has an avatar image, you might want to delete it.
        if ($user->avatar_url) {
            $imagePath = public_path('/uploads/avatars/' . $user->avatar_url);
            
            // Check if the file exists and delete it
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Detach roles if needed (this depends on your relationship setup)
        $user->roles()->detach();

        // Delete the user
        $user->delete();

        // Return a response indicating success
        return response()->json(['success' => true]);
    }

    

}

