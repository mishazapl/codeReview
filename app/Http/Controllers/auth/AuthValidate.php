<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;

interface AuthValidate
{
    public function validate(Request $request, array $rules);

    public function store(Request $request);
}