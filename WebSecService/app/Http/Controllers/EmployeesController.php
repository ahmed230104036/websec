<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeesController extends Controller
{
    public function index()
    {
        $employees = User::role('Employee')->get();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole('Employee');

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function show(User $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function edit(User $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, User $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $employee->id,
        ]);

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(User $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    public function customers()
    {
        $customers = User::role('Customer')->get();
        return view('employees.customers', compact('customers'));
    }

    public function addCredit(Request $request, User $user)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($user, $request) {
            $user->credit += $request->amount;
            $user->save();

            // Log credit addition
            DB::table('credit_history')->insert([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'type' => 'add',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return redirect()->back()->with('success', 'Credit added successfully.');
    }

    public function creditHistory(User $user)
    {
        $history = DB::table('credit_history')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('employees.credit_history', compact('user', 'history'));
    }

    public function reset(User $user)
    {
        $user->credit = 0;
        $user->save();

        return redirect()->back()->with('success', 'User credit reset successfully.');
    }
} 