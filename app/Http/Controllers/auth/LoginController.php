<?php

namespace App\Http\Controllers\auth;

use App\Users;
use Illuminate\Http\Request;

class LoginController extends AuthValidate
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
        $data = $this->validateDate
        (
            $request, array
            (
                'login'    => 'required|string|max:30',
                'email'    => 'required|string|max:50',
                'password' => 'required|string|max:40',
            )
        );

        $result = Users::where
        (
            [
                'login' => $data['login'],
                'email' => $data['email']
            ]
        )->select('password','token')->get()->first();

        /**
         * Проверяем корректность данных.
         */

        if (!is_object($result)) {
            return response()->json('Совпадений не найдено', 422);
        } elseif (is_null($result->token) || is_null($result->password)) {
            return response()->json('токен или пароль не найдены', 422);
        }


        /**
         * Сравниваем пароль с хешем.
         */

        $this->response
        (
            password_verify($data['password'], $result->password), $result->token,
            200, 422, 'Вы ввели неверный пароль!'
        );

    }
}
