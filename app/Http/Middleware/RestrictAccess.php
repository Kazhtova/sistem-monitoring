<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RestrictAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $guard): Response
    {
        if(!Auth::guard($guard)->check()){
            
        $role = Auth::guard('teknisi')->check() || Auth::guard('mahasiswa')->check();
        
            if($role){
                return redirect()->back();
            }

            return redirect()->route('login.mahasiswa');
        }

        return $next($request);
    }
}