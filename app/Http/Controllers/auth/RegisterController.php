<?php

namespace App\Http\Controllers\auth;

use App\User;
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
        /**
         * Передаем правила валидации.
         * @data
         */

        $data = $this->validatePost
        (
            $request, array
            (
                'login'    => 'required|unique:users|string|max:30',
                'email'    => 'required|unique:users|string|max:50',
                'password' => 'required|unique:users|string|max:40',
            )
        );

        /**
         * Сохраняем данные в массив.
         * @result
         */

        $result = User::create
        (
            [
            'login'    => $data['login'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
            'role_id'  => 1,
            'token'    => Str::random(32),
            ]
        );


        if ($result) {
            return response()->json(['', 'Вы зарегистрировались!'],200);
        } else {
            return response()->json(['', 'Что-то пошло не так'],520);
        }
    }
}
