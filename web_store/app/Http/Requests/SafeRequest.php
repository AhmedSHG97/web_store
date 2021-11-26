<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Session;

class SafeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (($this->path() == 'safe/store' || $this->path() == 'safe/update') && (!(userSession()->hasRole('admin') || userSession()->hasPermissionTo('modify-safe')))) {
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
        if ($this->path() == 'safe/store') {
            return [
                'name' => "required|string|unique:safes,name|min:3",
                'total_amount' => "required|numeric|min:4"
            ];
        }
        if ($this->path() == 'safe/update') {
            return [
                'id' => "required|numeric|exists:safes,id",
                'name' => "required|string|min:3|unique:safes,name,".$this->id,
                'total_amount' => "required|numeric|min:1"
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
            
            "id.exists" =>  __("auth.field_not_exist"),
            "name.required" => __("auth.name_required"),
            "name.min" =>  __("auth.name_min"),
            "name.max" =>  __("auth.name_max"),
            "total_amount.min" =>  __("website.total_amount_min"),
            "total_amount.required" =>  __("website.total_amount_required"),
            
        ];
    }
    protected function failedAuthorization()
    {
        session::flash('is_authorized', 0);
    }
}
