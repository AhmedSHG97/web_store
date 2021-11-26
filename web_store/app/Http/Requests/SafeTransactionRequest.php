<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Session;

class SafeTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (($this->path() == 'safe/transaction/store') && (!(userSession()->hasRole('admin') || userSession()->hasPermissionTo('modify-safe')))) {
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
        if ($this->path() == 'safe/transaction/store') {
            return [
                'user_id' => "required|exists:users,id|integer|min:1",
                'safe_id' => "required|exists:safes,id|integer|min:1",
                'transaction_type' => "required|string|in:withdraw,deposit",
                'transaction_amount' => "required|numeric|min:0",
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
            "safe_id.exists" =>  __("auth.field_not_exist"),
            "transaction_type.required" => __("website.transaction_type_required"),
            "transaction_type.in" => __("website.transaction_type_in"),
            "transaction_amount.required" => __("website.transaction_amount_required"),
            "transaction_amount.min" => __("website.transaction_amount_min"),
        ];
    }
    protected function failedAuthorization()
    {
        session::flash('is_authorized', 0);
    }
}
