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
        if (is_null($request->get('token'))) {
            return response()->json('Вы не передали токен', 404);
        }

        $token = (string) $request->get('token');

        $redis = Redis::connection();

        $user = $redis->get($token);

        if (!is_int($user)) {
            return response()->json([ 'error' => 404, 'message' => 'Ваш токен не найден, запросите его снова' ], 404);
        }

        return $next($request);
    }
}
