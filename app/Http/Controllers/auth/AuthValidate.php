<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Validate;
use Illuminate\Http\Request;

abstract class AuthValidate extends Validate
{
    /**
     * Через данный метод реализуется конечная отдача данных пользователю.
     * и установка токена в Redis в случае успеха.
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
            $tokenController = new TokenController;
            $tokenController->deleteUnRegToken(new Request);
            $tokenController->setAuth($successMessage);
            echo response()->json($successMessage, $success);
        } else {
            echo response()->json($failedMessage, $failed);
        }
    }

}