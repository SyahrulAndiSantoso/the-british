<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class is_kasir
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->check()){
            if(auth()->user()->role == 'kasir'){
                return $next($request);
            }else if(auth()->user()->role == 'admin'){
                return redirect('/admin/dashboard');
            }else if(auth()->user()->role == 'owner'){
                return redirect('/owner/dashboard');
            }
        }else{
            return redirect()->route('login-kasir');
        }
    }
}
