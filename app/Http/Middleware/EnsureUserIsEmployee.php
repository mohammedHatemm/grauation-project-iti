<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // تحقق مما إذا كان المستخدم مسجلاً وله دور "employee"
        if (Auth::check() && Auth::user()->role === 'employee') {
            return $next($request);
        }

        // إعادة توجيه المستخدم إذا لم يكن لديه الصلاحية
        abort(403, 'Unauthorized action.');
    }
}
