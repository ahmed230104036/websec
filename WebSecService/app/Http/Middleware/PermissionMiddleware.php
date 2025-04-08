<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        
        foreach($permissions as $permission) {
            if($user->hasPermissionTo($permission)) {
                return $next($request);
            }
        }

        return redirect()->back()->with('error', 'You do not have permission to access this page.');
    }
} 