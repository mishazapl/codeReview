<?php
/**
 * Created by PhpStorm.
 * User: misha
 * Date: 24.12.17
 * Time: 14:01
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class Validate extends Controller implements JsonValidate
{
    /**
     * Валидация данных для дочерних классов.
     *
     * @param Request $request
     * @param array $rules
     * @return array|string
     */
    protected function validateDate(Request $request, array $rules)
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
     * Вставка данных в таблицу, вначале метода вызывается метод validateDate.
     *
     * @param Request $request
     * @return mixed
     */
    abstract function store(Request $request);

    /**
     * Ответ приложения.
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