<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {   //die('here');
        if (Auth::guard($guard)->check()) {
            $user_id = Auth::user()->id;
            //echo "<pre>";print_r($user);exit;
            
            
            if (Auth::user()->is_admin==1) {
                return redirect('admin/users');
            }else{
                return redirect()->intended('dashboard/profile');
            }
            
        }

        return $next($request);
    }
}
