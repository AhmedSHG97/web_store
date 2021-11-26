<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Session;

class InvoiceProductsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (($this->path() == 'invoice/store') && (!(userSession()->hasRole('admin') || userSession()->hasPermissionTo('modify-safe')))) {
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
        if ($this->path() == 'invoice/store') {
            return [
                'user_id' => "required|integer|exists:users,id|min:3",
                'total' => "required|numeric|min:4"
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
            
            "user_id.exists" =>  __("auth.field_not_exist"),
            "total.min" =>  __("website.total_amount_min"),
            "total.required" =>  __("website.total_amount_required"),
            "subtotal.min" =>  __("website.total_amount_min"),
            "subtotal.required" =>  __("website.total_amount_required"),
            
        ];
    }
    protected function failedAuthorization()
    {
        session::flash('is_authorized', 0);
    }
}
