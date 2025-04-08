<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'string', 'in:Admin,Employee,Customer'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Allow users to change their own role
        if ($request->has('role')) {
            // Remove existing roles
            $user->syncRoles([]);
            // Assign new role
            $user->assignRole($request->role);
        }

        return redirect()->route('profile')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'credit' => 0, 
        ]);

        $user->assignRole('Customer');

        Auth::login($user);

        return redirect()->route('products.index')
            ->with('success', 'Registration successful! You can now start shopping.');
    }

    
    public function login()
    {
        return view('auth.login');
    }

    
    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    
    public function doLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    
    public function profile(User $user = null)
    {
        $user = $user ?? auth()->user();
        
        if ($user) {
            \Log::info('User Role Debug:', [
                'user_id' => $user->id,
                'name' => $user->name,
                'role_id' => $user->role_id,
                'is_admin' => $user->isAdmin(),
                'is_seller' => $user->isSeller(),
                'is_customer' => $user->isCustomer()
            ]);
        }
        
        return view('users.profile', compact('user'));
    }

    
    public function purchaseHistory()
    {
        $user = auth()->user();
        $purchases = $user->purchases()->with('product')->orderBy('created_at', 'desc')->get();
        return view('users.purchase_history', compact('purchases'));
    }

    
    public function save(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role_id' => ['required', 'integer', 'in:1,2,3'], 
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id, 
        ];

        $user->update($data);

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
} 