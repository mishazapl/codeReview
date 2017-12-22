<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

abstract class PostValidate extends Controller implements AuthValidate
{
    /**
     * Валидация данных для дочерних классов.
     *
     * @param Request $request
     * @param array $rules
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function validate(Request $request, array $rules)
    {

        $data = json_decode($request->post());

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            echo response()->json(['errors'=> $validator->errors()]);
            exit();
        }

        return $data;
    }

    abstract function store(Request $request);

}