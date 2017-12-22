<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\PostValidate;
use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class RegisterController extends PostValidate
{
    /**
     * Валидация и сохранение данных.
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {

        $data = $this->validatePost
        (
            $request, array
            (
                'login'    => 'required|unique:users|string|max:30',
                'email'    => 'required|unique:users|string|max:50',
                'password' => 'required|unique:users|string|max:40',
            )
        );

        $result = Users::create
        (
            [
            'login'    => $data['login'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
            'role_id'  => 1,
            'token'    => Str::random(32),
            ]
        );

        $this->response($result, ['token' => $result->token]);
    }
}
