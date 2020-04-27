<?php


namespace Tests\Unit;

use Tests\TestCase;

class UsersTest extends TestCase {

    private const URL = '/api/';
    private $token;

    /**
     * @covers App\Http\Controllers\AuthenticationController::register
     */
    public function testUserRegister() {
        $params = ["email" => "test99@email.com", "password" => "123456", "name" => "User Teste 99"];

        $this->json('post', self::URL . 'register', [$params])
            ->assertJsonStructure(
                [
                    "access_token",
                    "token_type",
                    "expires_in"
                ]
            );
    }

    /**
     * @covers App\Http\Controllers\AuthenticationController::login
     */
    public function testUserLogin() {
        $params = ["email" => "test2@email.com", "password" => "123456"];

        $objReturn = $this->post(self::URL . 'login?email=test2@email.com&password=123456', [$params])->getContent();

       $this->assertJsonStructure(
            [
                "access_token",
                "token_type",
                "expires_in",
            ], $objReturn);

    }

    /**
     * @covers App\Http\Controllers\AuthenticationController::getAuthUser
     */
    public function testAuthUser() {
        $this->get(self::URL . 'user', [], [], [
            'HTTP_AUTHORIZATION' => "{$this->token}",
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ])
            ->seeStatusCode(200)
            ->seeJsonStructure([
                '*' => [
                    "id",
                    "name",
                    "email",
                    "email_verified_at",
                    "created_at",
                    "updated_at"
                ]
            ]);
    }

    /**
     * @covers App\Http\Controllers\AuthenticationController::logout
     */
    public function testUserLogout() {
        $this->get(self::URL . 'user', [])
            ->seeStatusCode(200)
            ->seeJsonStructure([
                '*' => [
                    "message",
                ]
            ]);
    }
}