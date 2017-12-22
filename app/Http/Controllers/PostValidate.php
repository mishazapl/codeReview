<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


abstract class PostValidate extends Controller implements JsonValidate
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

        if (!$request->isJson()) {
            echo response()->json('Неверный формат данных!',409);
            exit();
        }

        $data = $request->post();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            echo response()->json(['errors' => $validator->errors()], 409);
            exit();
        }

        return $data;
    }

    /**
     * Вставка данных в таблицу, вначале вызывается метод validatePost.
     *
     * @param Request $request
     * @return mixed
     */

    abstract function store(Request $request);

    /**
     * Через данный метод реализуется конечная отдача данных пользователю.
     *
     * @param $condition
     * @param $successMessage
     * @param int $success
     * @param int $failed
     * @param string $failedMessage
     */

    public function response($condition, $successMessage, $success = 200, $failed = 520, $failedMessage = 'Что-то пошло не так')
    {
        if ($condition) {
            echo response()->json($successMessage, $success);
        } else {
            echo response()->json($failedMessage, $failed);
        }
    }

}