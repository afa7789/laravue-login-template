<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use \Illuminate\Validation\ValidationException;
use App\Http\Requests\Api\Login\LoginFormRequest;
use App\Http\Resources\Login\ResponseResource;

/**
 * @group Auth endpoints
 */
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Receive user request, confirm login attempts , and return a response json with token and user.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse 
     */
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        // if ($response = $this->authenticated($request, $this->guard()->user())) {
        //     return $response;
        // }

        return new ResponseResource([
            'status' => true,
            'token'  => $request->user()->createToken($request->input('device_name'))->accessToken,
            'user'   => $request->user()
        ]);
    }

    /**
     * Log the user out of the application.
     *
     *
     * @param \Illuminate\Http\Request $request
     * @return boolean
     * 
     */
    public function logout(Request $request)
    {
        /* @authenticated
        * @response status=204 scenario="Success" {}
        * @response status=400 scenario="Unauthenticated" {
        *     "message": "Unauthenticated."
        * }
        * \Illuminate\Http\Response*/
        // $request->user()->token()->revoke();
        return $request->user()->token()->revoke();
        // return new Response();
        // return $request->wantsJson()
        //     ? new Response('', 204)
        //     : new Response('',400);
    }

    /**
     * Handle a login request to the application.
     *
     * @bodyParam email email required The email of the user. Example: demo@demo.com
     * @bodyParam password password required The password of the user. Example: password
     *
     * @response status=422 scenario="Validation error" {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "email": [
     *            "The email field is required."
     *        ]
     *    }
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse|boolean
     *
     */
    public function login(LoginFormRequest $request)
    {
        try{
            $this->validateLogin($request);
        }catch(ValidationException $except){
            dd($except);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        // $failed = $this->sendFailedLoginResponse($request);

        return $this->failedResponse($request);
    }

    /**
     * Return a json with status false and message of failure.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function failedResponse($request){
        return new ResponseResource([
            'status' => false,
            'message' => [trans('auth.failed')],
            'user' => $request->email
        ]);
    }
}
