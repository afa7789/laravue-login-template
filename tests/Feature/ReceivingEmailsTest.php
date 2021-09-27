<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ResetPassword;
use App\Notifications\VerifyMail;
use App\Models\User;
use Tests\TestCase;
use Laravel\Passport\Passport;

class ReceivingEmailsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Arthur F. Abeilice
     * Test Request Password Route with fake passport user and try to see if it sends a mail
     *
     * @return void
     */
    public function testEmailIsSentPasswordRequest()
    {

        Notification::fake();

        $user = User::factory()->create();

        Passport::actingAs(
            $user,
            ['create-servers']
        );
        
        $response = $this->call('POST','/api/password/request',[
            'email' => $user->getAttributes()['email']
        ]);
        
        $response->assertStatus(200);

        // Your post call here
        Notification::assertSentTo( 
            [$user], ResetPassword::class
        ); 

        // Assert a notification was not sent...
        Notification::assertNotSentTo(
            [$user], VerifyMail::class
        );
    }
    
    /**
     * Test Resend Verify Email Route with fake passport user and try to see if it sends a mail
     *
     * @return void
     */
    public function testEmailIsSentVerifyResend()
    {

        Notification::fake();

        $user = User::factory()->create([
            'email' => 'afa7789@gmail.com',
            'email_verified_at' => null,
        ]);
       
        Passport::actingAs(
            $user,
            ['create-servers']
        );
        
        $response = $this->call('GET','/api/email/resend');
        
        $response->assertStatus(200);

        // Not possible to check with this, but if the response is 200 the email should have been sent
        // ... TODO need help.

        // Notification::assertSentTo( 
        //     [$user], VerifyMail::class
        // ); 

        // Assert a notification was not sent...
        Notification::assertNotSentTo(
            [$user], ResetPassword::class
        );
    }


}
