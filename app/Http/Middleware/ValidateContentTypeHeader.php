<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateContentTypeHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$this->validHeader($request))
            return response()->json([
                "errors" => [
                    "status" => "406",
                    "title" => "Not Acceptable",
                    "detail" => "You must include Content-Type header with 'application/vnd.api+json' value.",
                    "source" => [
                        "pointer" => "Content-Type Header"
                    ]
                ]
            ], 406);
        
        return $next($request);
    }

    public function validHeader($request){
        $hasContentTypeHeader = $request->headers->has('Content-Type');
        $hasValidContentTypeHeader = $request->header('Content-Type') === 'application/vnd.api+json';

        return $hasContentTypeHeader && $hasValidContentTypeHeader;
    }
}
