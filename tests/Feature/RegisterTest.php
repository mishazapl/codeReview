<?php

namespace Tests\Feature;

use App\Users;
use Illuminate\Support\Str;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * 3 раза делает запрос на регистрацию используя RegisterController.
     * сразу после запроса очищает бд.
     *
     * @test
     */
    public function testRegisterController()
    {
        for ($i = 0; $i < 3; $i++) {

            $tmp = $this->dataRegisterController($i);

            $response = $this->json('POST', '/api/v1/user/register', $tmp);

            Users::where('login', '=', $tmp['login'])->delete();

            $response->assertStatus(200);
        }
    }

    public function dataRegisterController($loop)
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
