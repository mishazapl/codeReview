<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


abstract class PostValidate extends Controller implements AuthValidate
{
    /**
     * Валидация данных для дочерних классов.
     *
     * @param Request $request
     * @param array $rules
     * @return array|string
     */
    public function validatePost(Request $request, array $rules)
    {
        /**
         * Если не JSON вернуть ошибку 409.
         */
        if (!$request->isJson()) {
            echo response()->json('Неверный формат данных!',409);
            exit();
        }

        /**
         * Получаем данные из POST и валидируем по правилам из дочернего класса.
         * @data json
         *
         */

        $data = $request->post();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            echo response()->json(['errors' => $validator->errors()], 409);
            exit();
        }

        return $data;
    }

    abstract function store(Request $request);

}