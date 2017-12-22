<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\PostValidate;
use App\Users;
use Illuminate\Http\Request;

class LoginController extends PostValidate
{
    /**
     * Валидация, поиск пользователя в бд.
     * В случае если пользователь найден возращать токен
     * и записовать в redis и удалять предедущий.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $this->validate
        (
            $request, array
            (
                'login'    => 'required|string|max:30',
                'email'    => 'required|string|max:50',
                'password' => 'required|string|max:40',
            )
        );

        $token = Users::where
        (
            [
                'login'    => $data['login'],
                'email'    => $data['email'],
                'password' => $data['password'],
            ]
        )->select('token')->limit(1);


        $this->response($token, ['token' => $token]);

    }
}
