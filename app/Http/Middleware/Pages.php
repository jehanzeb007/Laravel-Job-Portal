<?php

namespace App\Http\Middleware;


use Closure;



class Pages
{

    public function handle($request, Closure $next, $guard = null)
    {
        //die('here');

        $page_fields  = array(1,2);
        $request->merge(array("page_fields" => $page_fields));
        //$request->attributes->add(['page_fields' => $page_fields]);

        return $next($request);
    }
}
