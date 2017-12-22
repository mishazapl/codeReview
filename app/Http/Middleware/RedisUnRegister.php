<?php

namespace App\Http\Middleware;

use Closure;
use Redis;

class RedisUnRegister
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = (string) $request->get('token');

        $redis = new Redis();

        $user = $redis->get($token);

        if ($user != 'unRegister') {
            return response()->json([ 'error' => 404, 'message' => 'Ваш токен не найден, запросите его снова' ], 404);
        }

        return $next($request);
    }
}
