<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginRouteTest extends TestCase
{

    /**
     * @author Arthur F. Abeilice
     * test login post route with correct email and password parameters
     * call the post
     * assert the status of the data in it's response
     * @return void
     */
    public function testCheckLoginWithExistingAccount()
    {
        $parameters = [
            'email' => 'admin@admin.com',
            'password' => 'password',
        ];

        $response = $this->call('POST', '/api/login', $parameters);

        $dataAsJson = $response->json();
        $this->assertTrue($dataAsJson["status"]);
    }

    /**
     * @author Arthur F. Abeilice
     * test login post route with correct email and password parameters
     * call the post
     * assert the status of the data in it's response
     * @return void
     */
    public function testCheckLoginWithExistingAccountAndWrongPassword()
    {
        $parameters = [
            'email' => 'admin@admin.com',
            'password' => 'pa222ssword',
        ];

        $response = $this->call('POST', '/api/login', $parameters);

        $dataAsJson = $response->json();

        $this->assertTrue(!$dataAsJson["status"]);
    
    }

    /**
     * @author Arthur F. Abeilice
     * test login post route with incorrect email and password parameters
     * call the post
     * assert the status of the data in it's response
     *
     * @return void
     */
    public function testCheckLoginWithNonExistingAccount()
    {
        $parameters = [
            'email' => 'admin666@admin.com',
            'password' => 'password',
        ];

        $response = $this->call('POST', '/api/login', $parameters);

        $dataAsJson = $response->json();

        $this->assertTrue(!$dataAsJson["status"]);
    
    }
}
