<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

interface JsonValidate
{
    public function validate(Request $request, array $rules);

    public function store(Request $request);

    public function response($condition, $successMessage, $success = 200, $failed = 500, $failedMessage = 'Что-то пошло не так');
}