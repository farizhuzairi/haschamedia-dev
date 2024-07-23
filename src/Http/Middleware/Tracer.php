<?php

namespace HaschaDev\Http\Middleware;

use Closure;
use HaschaDev\Dev;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class Tracer
{
    public function __construct(private Dev $dev)
    {}

    public function handle(Request $request, Closure $next): Response
    {
        if(empty(csrf_token()) || empty(Route::currentRouteName())){
            throw new \Exception("Error Processing Request: _trace atau routeName tidak ditemukan.", 1);
            
        }

        $this->dev->setTrace(
            Route::currentRouteName(),
            csrf_token()
        );
        return $next($request);
    }
}
