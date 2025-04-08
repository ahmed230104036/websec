<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Admin');
    }

    // Show employee creation form
    public function createEmployee()
    {
        return view('admin.create_employee');
    }

    // Store a new employee
    public function storeEmployee(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Employee',
            'credit' => 0.00,
        ]);

        return redirect()->route('admin.create_employee')->with('success', 'Employee created successfully.');
    }
}