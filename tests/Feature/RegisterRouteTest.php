<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RegisterRouteTest extends TestCase
{
    
    use DatabaseTransactions;

    /**
     * @author Arthur F. Abeilice
     * Test Register Route with correct parameters
     *
     * @return void
     */
    public function testCheckRegisterWithNewAccount()
    {
        $parameters = [
            'name' => 'nicolau',
            'email' => 'admin2@admin.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->call('POST', '/api/register', $parameters);
        // TODO perguntar ao raphael como ignora o data wrapper
        $dataAsJson = $response->json();
        $this->assertTrue($dataAsJson["status"]);
    
    }


    /**
     * @author Arthur F. Abeilice
     * Test Register Route with incorrect parameters
     *
     * @return void
     */
    public function testCheckRegisterWithAccountConflit()
    {
        $parameters = [
            'name' => 'nicolau',
            'email' => 'admin@admin.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->call('POST', '/api/register', $parameters);

        $dataAsJson = $response->json();
        $this->assertTrue(!$dataAsJson["status"]);
    }

}
