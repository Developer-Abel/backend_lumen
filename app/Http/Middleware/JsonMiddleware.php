<?php

namespace App\Http\Middleware;

use Closure;

class JsonMiddleware{
    public function handle($request, Closure $next){
        if ($request->isjson()) {
            return $next($request);
        }
        return response()->json([
            'response' => 'FORMATO NO VALIDO'
        ],402);

    }
}
