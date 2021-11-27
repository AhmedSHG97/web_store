<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Session;

class SettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (($this->path() == 'settings/update') && (!(userSession()->hasRole('admin') || userSession()->hasPermissionTo('modify-settings')))) {
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
        if ($this->path() == 'settings/update') {
            return [
                'id' => "required|integer|exists:settings,id",
                'address' => "required|string|min:3",
                'app_phone' => "required|string|min:11",
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
            "address.required" => __("website.address_required"),
            "address.min" =>  __("website.address_min"),
            "app_phone.required" => __("website.app_phone_required"),
            "app_phone.min" =>  __("website.app_phone_min"),
        ];
    }
    protected function failedAuthorization()
    {
        session::flash('is_authorized', 0);
    }
}
