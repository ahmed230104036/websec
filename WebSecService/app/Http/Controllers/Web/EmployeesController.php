<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Employee');
    }

    public function customers()
    {
        $customers = User::role('Customer')->get();
        return view('employees.customers', compact('customers'));
    }

    public function addCredit(Request $request, User $user)
    {
        $request->validate([
            'credit' => 'required|numeric|min:0',
        ]);

        if (!$user->hasRole('Customer')) {
            return redirect()->back()->with('error', 'Can only add credit to customers.');
        }

        $user->credit += $request->credit;
        $user->save();

        return redirect()->route('employees.customers')->with('success', 'Credit added successfully.');
    }

    public function reset(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'amount' => '0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->credit += 000;
        $user->save();

        return back()->with('success', 'Credit Balance become zero');
    }
}