<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $lang = $request->locale;
        if($lang == 'en' || $lang =='id'){
            App::setLocale($lang);
        } else {
            App::setLocale('en');
        }
        
        return $next($request);
    }
}