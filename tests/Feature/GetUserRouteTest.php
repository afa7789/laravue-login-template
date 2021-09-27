<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Laravel\Passport\Passport;

class GetUserRouteTest extends TestCase
{
    /**
     * @author Arthur F. Abeilice
     * Test using Passport actin an authenticate user being returned.
     *
     * @return void
     */
    public function test_authentication_get_user_route()
    {   
       
        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );

        $response = $this->call('GET','/api/user');
        
        $response->assertStatus(200);

    }
}
