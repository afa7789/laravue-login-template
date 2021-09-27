<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Password Reset
Route::group(['namespace' => 'App\Http\Controllers\Api'],function(){

    /**
     * @OA\Post(
     *      path="/api/password/request",
     *      tags={"link","password","reset"},
     *      operationId="SendResetLink",
     *      description="Send a link to access reset a password reset",
     *      @OA\Parameter(name="email",
     *          description="User email",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="email")
     *      ),
     *      @OA\Response(response="200",
     *          description="This will have a success boolean , true or false. And a message in case it's needed",
     *      ),
     *      @OA\Response(
     *          response="400",
     *          description="Form request validation error. Invalid input."
     *      ),
     * )
     */
    Route::post('/password/request', 'PasswordResetController@sendResetLinkEmail');

    //TODO need to auth this i think
    /**
     * @OA\Post(
     *      path="/api/password/token",
     *      tags={"token","password","reset"},
     *      operationId="RequestToken",
     *      description="Send the token used by a password reset",
     *      @OA\Parameter(name="email",
     *          description="User email",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="email")
     *      ),
     *      @OA\Response(response="200",
     *          description="Resource with the token",
     *      ),
     *      @OA\Response(
     *          response="400",
     *          description="Form request validation error. Invalid input."
     *      ),
     * )
     */
    Route::post('/password/token', 'PasswordResetController@getToken');

    /**
     * @OA\Post(
     *      path="/api/password/reset",
     *      tags={"password","reset","request","post"},
     *      operationId="PasswordResetPost",
     *      description="Send the new Password to be reset",
     *      @OA\Parameter(name="email",
     *          description="User email",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(name="token",
     *          description="Backend Token",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(name="password",
     *          description="new password",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(name="password_confirmation",
     *          description="new password confirmed",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(response="200",
     *          description="Resource with success true or false",
     *      ),
     *      @OA\Response(
     *          response="400",
     *          description="Form request validation error. Invalid input."
     *      ),
     * )
     */
    Route::post('/password/reset', 'PasswordResetController@reset')->name('password.reset');
    
    /**
     * @OA\Get(
     *      path="/api/password/reset",
     *      tags={"password","reset","request","get"},
     *      operationId="PasswordResetGet",
     *      description="Send the new Password to reset",
     *      @OA\Parameter(name="email",
     *          description="User email",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(name="token",
     *          description="Backend Token",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(name="password",
     *          description="new password",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(name="password_confirmation",
     *          description="new password confirmed",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(response="200",
     *          description="Resource with success true or false",
     *      ),
     *      @OA\Response(
     *          response="400",
     *          description="Form request validation error. Invalid input."
     *      ),
     * )
     */
    Route::get('/password/reset', 'PasswordResetController@reset')->name('password.reset');

});

Route::group(['namespace' => 'App\Http\Controllers\Api', 'as' => 'api'], function () {
 
    /**
     * @OA\Post(
     *      path="/api/login",
     *      tags={"login"},
     *      operationId="LoginRequest",
     *      description="Login with user and pass, return the user data",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(name="email",
     *          description="User email",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(name="password",
     *          description="new password",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(response="200",
     *          description="Resource with status true or false, if true will return the user data correctly",
     *      ),
     *      @OA\Response(
     *          response="400",
     *          description="Form request validation error. Invalid input."
     *      ),
     * )
     */
    Route::post('login', 'LoginController@login')->name('login');

    /**
     * @OA\Post(
     *      path="/api/register",
     *      tags={"user","register"},
     *      operationId="Register",
     *      description="Register New User",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(name="email",
     *          description="User email",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(name="name",
     *          description="User name",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(name="password",
     *          description="password",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(name="password_confirmation",
     *          description="password confirmation",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(response="200",
     *          description="Resource with success true or false",
     *      ),
     *      @OA\Response(
     *          response="400",
     *          description="Form request validation error. Invalid input."
     *      ),
     * )
     */
    Route::post('register', 'RegisterController@register')->name('register');

    Route::group(['middleware' => ['auth:api']], function () {

        /**
         * @OA\Get(
         *      path="/api/email/verify/{hash}",
         *      tags={"hash","email","verify","get"},
         *      operationId="Verify",
         *      description="Receives a hash from an email that should verificate the email from user",
         *      security={{"bearerAuth":{}}},
         *      @OA\Parameter(name="hash",
         *          description="Hash created by the system",
         *          in="query",
         *          required=true,
         *          @OA\Schema(type="string")
         *      ),
         *      @OA\Response(response="200",
         *          description="Resource with success true or false",
         *      ),
         *      @OA\Response(
         *          response="400",
         *          description="Form request validation error. Invalid input."
         *      ),
         * )
         */
        Route::get('email/verify/{hash}', 'VerificationController@verify')->name('verification.verify');

        /**
         * @OA\Get(
         *      path="/api/email/resend",
         *      tags={"resend","email","verify"},
         *      operationId="ResendVerifyMail",
         *      description="Accordingly to the AUTH token it will send an email to verify the account",
         *      security={{"bearerAuth":{}}},
         *      @OA\Response(response="200",
         *          description="Just a 200",
         *      ),
         *      @OA\Response(
         *          response="400",
         *          description="Form request validation error. Invalid input."
         *      ),
         * )
         */
        Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');

        /**
         * @OA\Get(
         *      path="/api/user",
         *      tags={"get","user","data"},
         *      operationId="GetUserData",
         *      description="Get User Data in accord to the auth token received",
         *      security={{"bearerAuth":{}}},
         *      @OA\Response(response="200",
         *          description="Just a 200",
         *      ),
         *      @OA\Response(
         *          response="400",
         *          description="Form request validation error. Invalid input."
         *      ),
         * )
         */
        Route::get('user', 'AuthenticationController@user')->name('user');

        /**
         * @OA\Get(
         *      path="/api/logout",
         *      tags={"logout","user","auth"},
         *      operationId="Logout",
         *      description="Logout the user that's in accord to the auth token received",
         *      security={{"bearerAuth":{}}},
         *      @OA\Response(response="200",
         *          description="Just a 200",
         *      ),
         *      @OA\Response(
         *          response="400",
         *          description="Form request validation error. Invalid input."
         *      ),
         * )
         */
        Route::get('logout', 'LoginController@logout')->name('logout');

    });
    
}); 