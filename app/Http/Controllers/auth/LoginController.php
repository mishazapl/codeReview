<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;

class LoginController extends PostValidate
{
    public function store(Request $request)
    {
        $data = $this->validate
        (
            $request, array
            (
                'login'    => 'required|string|max:30',
                'email'    => 'required|string|max:50',
                'password' => 'required|string|max:40',
            )
        );
    }
}
