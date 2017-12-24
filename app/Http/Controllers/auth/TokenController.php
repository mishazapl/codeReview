<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;


class TokenController extends Controller
{
    /**
     * Переменная хранит подключение к Redis
     *
     * @var Redis
     */
    private $redis;

    /**
     * Подключение к Redis.
     *
     * TokenController constructor.
     */
    public function __construct()
    {
        $this->redis = Redis::connection();
    }

    /**
     * Генерация токена и отдача клиенту не прошедшего аутентифика́цию.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function setUnRegister()
    {
        $token = Str::random(25);
        $this->redis->set($token, 0);
        $this->redis->expire($token, 1200);

        return response()->json(['token' => $token], 200);
    }

    /**
     * Запись токена в базу авторизованного пользователя.
     * @param $token
     */
    public function setAuth($token)
    {
        $nameRole = Users::where('token', '=', $token)->with('role')->get()->first()->role->name;
        $this->redis->set($token, $nameRole);
        $this->redis->expire($token, 10800);
    }

    /**
     * Удаляем старый токен, если он существует.
     * @param Request $request
     */
    public function deleteUnRegToken(Request $request)
    {
        if (!is_null($request->get('token'))) {
            $this->redis->del($request->get('token'));
        }
    }
}
