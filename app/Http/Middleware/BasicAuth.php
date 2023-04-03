<?php

namespace App\Http\Middleware;

use App\Exceptions\UnAuthException;
use App\Providers\RouteServiceProvider;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class BasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $configLogin = "user";
        $configKey = "123456";

        $authorization = $request->header('authorization');

        if ($authorization && 0 === stripos($authorization, 'basic ')) {
            $exploded = explode(':', base64_decode(substr($authorization, 6)), 2);

            if (2 == count($exploded)) {
                list($login, $key) = $exploded;

                if ($login === $configLogin && $key === $configKey) {
                    return $next($request);
                }
            }
        }

        throw new UnAuthException('INVALID_AUTH', 401);
    }
}
