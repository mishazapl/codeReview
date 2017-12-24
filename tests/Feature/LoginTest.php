<?php

namespace Tests\Feature;

use App\Users;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    /**
     * Делает запрос на авторизацию в LoginController
     * но перед этим вызывает метод вставки в таблицу значений.
     * После отработки теста вставленные значения удаляются.
     *
     * SetUp в данном тесте отключен по причине не работоспособности!
     *
     * @test
     */
    public function testLoginController()
    {
        //$this->withoutMiddleware();

        $insertData = $this->providerLoginController();

        Users::create
        (
            [
                'login'    => $insertData['login'],
                'email'    => $insertData['email'],
                'password' => bcrypt($insertData['password']),
                'role_id'  => 1,
                'token'    => Str::random(32),
            ]
        );

        $response = $this->json('POST', '/api/v1/user/auth', $insertData);

        $response->assertStatus(200);
    }

    public function providerLoginController()
    {
        $data =
            [
                array
                (
                    'login'    => 'test',
                    'email'    => 'test@mail.ru',
                    'password' => '123456',
                )
            ];

        return $data[0];
    }

    public function tearDown()
    {
        $tmp = $this->providerLoginController();

        Users::where('login', '=', $tmp['login'])->delete();
    }
}
