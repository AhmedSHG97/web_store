<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Session;



class UserAuthenticationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->path() == "signIn") {
            return [
                "email" => "required|email|min:8|max:191|exists:users,email",
                "password" => [
                    'required',
                    'min:6',
                    "max:191",
                    'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
                ],
            ];
        }
        if ($this->path() == "forgot/password") {
            return [
                "email" => "required|email|min:8|max:191|exists:users,email",
            ];
        }
        if ($this->path() == "change/password") {
            return [
                "token" => "required|min:10|max:191|exists:password_resets,token",
                "password" => [
                    'required',
                    'min:6',
                    "max:191",
                    'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
                    'confirmed'
                ],
            ];
        }
        if ($this->path() == "register") {
            return [
                "email" => "required|email|unique:users,email|min:8|max:191",
                "password" => [
                    'required',
                    'min:6',
                    "max:191",
                    'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
                    'confirmed'
                ],
                "name" => "required|min:4|max:191",

            ];
        }
        return [];
    }

    protected function failedValidation(Validator $validator)
    {
        Session::flash('validation_message', $validator->errors()->first()); 
    }
    public function messages()
    {
        return [
            "email.required" => __('auth.email_required'),
            "email.unique" =>  __("auth.user_already_exists"),
            "email.email" => __("auth.not_valid_email"),
            "email.min" => __("auth.email_min"),
            "email.max" => __("auth.email_max"),
            "email.exists" => __("auth.user_not_exists"),
            "id.exists" =>  __("auth.user_not_exists"),
            "password.required" => __("auth.password_required"),
            "password.confirmed" => __("auth.password_confirmed"),
            "password.min" => __("auth.password_min"),
            "password.max" => __("auth.password_max"),
            "password.regex" => __("auth.password_regex"),
            "name.required" => __("auth.name_required"),
            "name.min" =>  __("auth.name_min"),
            "name.max" =>  __("auth.name_max"),
            "token.required" => __("auth.token_required"),
            "token.exists" => __("auth.token_exists"),
        ];
    }
}
