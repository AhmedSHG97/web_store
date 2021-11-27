<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Session;

class InvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (($this->path() == 'invoice/store' || $this->path() == 'invoice/update') && (!(userSession()->hasRole('admin') || userSession()->hasPermissionTo('modify-safe')))) {
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
                'invoice_to' => "required|string|min:3",
                'invoice_owner_address' => "required|string|min:3",
                'invoice_owner_phone' => "required|string|min:11",
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
            "invoice_to.required" => __("website.invoice_to_required"),
            "invoice_to.min" =>  __("website.invoice_to_min"),
            "invoice_owner_address.required" => __("website.invoice_owner_address_required"),
            "invoice_owner_address.min" =>  __("website.invoice_owner_address_min"),
            "invoice_owner_phone.required" => __("website.invoice_owner_phone_required"),
            "invoice_owner_phone.min" =>  __("website.invoice_owner_phone_min"),
        ];
    }
    protected function failedAuthorization()
    {
        session::flash('is_authorized', 0);
    }
}
