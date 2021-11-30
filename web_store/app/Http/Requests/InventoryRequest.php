<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Session;

class InventoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (($this->path() == 'inventory/store' || $this->path() == 'inventory/update') && (!(userSession()->hasRole('admin') || userSession()->hasPermissionTo('modify-inventories')))) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->path() == 'inventory/store') {
            return [
                'image' => "nullable|mimes:jpeg,png,jpg,gif,svg|max:2048",
                'name' => "required|string|unique:inventories,name|min:3",
                'address' => "required|string|min:4"
            ];
        }
        if ($this->path() == 'inventory/update') {
            return [
                'id' => "required|numeric|exists:inventories,id",
                'image' => "nullable|mimes:jpeg,png,jpg,gif,svg|max:2048",
                'name' => "required|string|min:3|unique:inventories,name,".$this->id,
                'address' => "required|string|min:4"
            ];
        }
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
            "id.exists" =>  __("auth.field_not_exist"),
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
            "address.required" => __("website.address_required"),
            "address.min" => __("website.address_min"),
            "image.mimes" => __("website.image_mimes"),
            "image.required" => __("website.image_required"),
        ];
    }
    protected function failedAuthorization()
    {
        session::flash('is_authorized', 0);
    }
}
