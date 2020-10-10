<?php

namespace App\Http\Middleware;

use App\Exceptions\UnauthorizedException;
use App\Services\JwtService;
use Closure;
use Exception;

class JwtMiddleware
{
    protected $jwtService;

    public function __construct(JwtService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    public function handle($request, Closure $next)
    {
        $authorization = $request->header('Authorization', '');
        $token = preg_match('/^Bearer (.+)$/', $authorization, $match) ? $match[1] : '';
        try {
            $payload = $this->jwtService->extractPayload($token);
            $request->attributes->add([
                'memberId' => $payload->memberId,
            ]);
        } catch (Exception $e) {
            throw new UnauthorizedException('token is no validated.');
        }

        return $next($request);
    }
}
