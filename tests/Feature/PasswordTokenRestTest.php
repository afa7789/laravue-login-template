<?php

namespace Tests\Feature;
use Illuminate\Support\Facades\Password;

use Tests\TestCase;

class PasswordTokenRestTest extends TestCase
{

    /**
     * @author Arthur F. Abeilice
     * Test if it returns a correct token to admin default account
     *
     * @return void
     */
    public function testPasswordTokenRequestRoute()
    {
        $parameters = [
            'email' => 'admin@admin.com',
        ];

        $response = $this->call('POST', '/api/password/token', $parameters);

        $response->assertStatus(200);
    
    }

    /**
     * @author Arthur F. Abeilice
     * Test if reset password route works
     * 
     * @return void
     */
    public function testPasswordResetRoute()
    {
        $email = "admin@admin.com";

        $parameters = [
            'email' => $email,
        ];

        $user = Password::broker('users')->getUser(["email"=>$email]);

        $token = Password::broker('users')->createToken($user);

        $parameters = [
            'email' => $email,
            'token' => $token,
            'password' => "password",
            'password_confirmation' => "password",
        ];

        $response = $this->call('POST', '/api/password/reset', $parameters);

        $response->assertStatus(200);
    
    }
}
