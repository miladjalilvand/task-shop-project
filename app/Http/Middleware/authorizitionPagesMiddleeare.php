<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class authorizitionPagesMiddleeare
{
public function handle(Request $request, Closure $next)
    {
        
        if (Auth::check()) {
            return redirect('/'); 
        }

       


        return $next($request);
    }
}
