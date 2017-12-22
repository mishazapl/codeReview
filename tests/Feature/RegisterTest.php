<?php

namespace Tests\Feature;

use Illuminate\Support\Str;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testInsertJson()
    {
        for ($i = 0; $i < 3; $i++) {

            $response = $this->json('POST', '/api/v1/user/register', $this->dataInsertJson($i));

            $response->assertStatus(200);
        }
    }

    public function dataInsertJson($loop)
    {
        $data =
            [
                array
                (
                    'login'    => Str::random(20),
                    'email'    => Str::random(7).'@mail.ru',
                    'password' => Str::random(30),
                ),

                array
                (
                    'login'    => Str::random(30),
                    'email'    => Str::random(10).'@mail.ru',
                    'password' => Str::random(12),
                ),

                array
                (
                    'login'    => Str::random(6),
                    'email'    => Str::random(15).'@mail.ru',
                    'password' => Str::random(11),
                ),
            ];

        $result = $data[$loop];

        return $result;
    }
}
