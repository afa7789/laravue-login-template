<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Password\PasswordFormRequest;
use App\Http\Requests\Api\Password\PasswordResetFormRequest;

use App\Http\Resources\Password\ResetLinkRequestResource;
use App\Http\Resources\Password\ResetResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

use App\Notifications\ResetPassword;
use Illuminate\Support\Arr;
use Illuminate\Auth\DatabaseUserProvider;

// use UnexpectedValueException;
// use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
/**
 * @group Auth endpoints
 */
class PasswordResetController extends Controller
{

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResetLinkEmail(PasswordFormRequest $request)
    {   
        $returned_stat = $this->broker()->sendResetLink( $request->only('email' ) );

        if( $returned_stat == Password::RESET_LINK_SENT ){
            return new ResetLinkRequestResource([
                'success' => true 
            ]);
        }else{
            return new ResetLinkRequestResource([
                'success' => false,
                'message' => trans($returned_stat)
            ]);
        }
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reset(PasswordResetFormRequest $request)
    {
        // $this->validate($request, $this->rules(), $this->validationErrorMessages());

        $response = $this->broker()->reset(
            $this->credentials($request), 
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        if ( $response == Password::PASSWORD_RESET ) {
            return new ResetResource([
                'success' => true,
            ]);
        }

        return new ResetResource([
            'success' => false,
        ]);
    }

     /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [];
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     *
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);

        $user->save();

        event(new PasswordReset($user));

        return $user;
    }

    /**
     * Get the user from an email and create a new token for it.
     * 
     * @param $request have user email.
     * @return token 
     */
    public function getToken(PasswordFormRequest $request){
        $user = $this->broker()->getUser($request->only('email'));
        return $this->broker()->createToken($user);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */
    protected function broker()
    {
        return Password::broker('users');
    }
}
