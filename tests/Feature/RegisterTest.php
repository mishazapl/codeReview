<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testInsert()
    {

        $data =
        (
            [
                'login'    => 'misha',
                'email'    => 'misha@mail.ru',
                'password' => '1122Ddcdcweedcdfgs'
            ]
        );

        $response = $this->json('POST', 'api/v1/user/register', $data);

        $response->assertStatus(200);
    }

}
