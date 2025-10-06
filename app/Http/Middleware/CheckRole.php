<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        
        if (!Auth::check()) {
            return redirect('/login'); 
        }

       
        $userRole = Auth::user()->role;

      
        if ($userRole === 'user' ) {
            abort(403, 'شما اجازه‌ی دسترسی به این صفحه را ندارید.');
        }

        return $next($request);
    }
}
