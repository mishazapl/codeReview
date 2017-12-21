<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Users;


class RegisterController extends PostValidate
{
    /**
     * Сохранение данных.
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $data = $this->validate
        (
            $request, array
            (
                'login'    => 'required|unique:users|string|max:30',
                'email'    => 'required|unique:users|string|max:50',
                'password' => 'required|unique:users|string|max:40',
            )
        );

        return Users::create
        (
            [
            'login'    => $data['login'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
            'token'    => Str::random(32),
            ]
        );
    }
}
