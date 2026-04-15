<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InternalServiceMiddleware {
    public function handle(Request $request, Closure $next): Response {
        $token = $request->header('X-Internal-Token');
        if (!$token || $token !== config('app.internal_token'))return ApiResponse::error('FORBIDDEN', 'Direct access is not allowed', 403);
        return $next($request);
    }
}