<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected function registered($request, $user)
    {
        $user->role_id = Role::where('name', 'Customer')->first()->id;
        $user->save();
    }
}