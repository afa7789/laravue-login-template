<?php

namespace App\Http\Requests\Api\Login;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;


class LoginFormRequest extends FormRequest{
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     *
     */
    public function rules(){
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */    
    public function messages(){
        return [
            'email.required' => 'The email field of the user is required.',
            'email.email' => 'Email must be of format of email',
            'password.required' => 'The password field is required.', 
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(){

    }    

    /**
     * In case validation fails , return message.
     * 
     * @return Json
     */
    protected function failedValidation(Validator $validator){   
        // catch error messages     
        $error_messages = $validator->errors()->all();

        // Shown Error Parameters
        throw new HttpResponseException(
            response()->json(
                [
                    'status' => false,
                    'success' => false,
                    'error' => $error_messages[0],
                    'error_code' => 10,##\ApiErrors::REQUEST_FAILED, #ApiErrors
                    'message' => $error_messages,
                ],
                422
        ));
    }

}
