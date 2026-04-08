<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class EnsureRequestId
{
    public function handle(Request $request, Closure $next): Response
    {
        $incomingRequestId = $request->headers->get('X-Request-Id');
        $requestId = $incomingRequestId && Str::isUuid($incomingRequestId)
            ? $incomingRequestId
            : (string) Str::uuid();

        $request->attributes->set('request_id', $requestId);
        $request->attributes->set('trace_id', $requestId);

        $response = $next($request);
        $response->headers->set('X-Request-Id', $requestId);

        return $response;
    }
}
