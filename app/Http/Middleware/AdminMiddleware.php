<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class AdminMiddleware
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next, $guard = null)
    {
        //echo Auth::guard($guard)->check();
        //exit;
        if (!Auth::guard($guard)->check()) {

            return redirect('admin/login');
        }
        return $next($request);
    }
}
