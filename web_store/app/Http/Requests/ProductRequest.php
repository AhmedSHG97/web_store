<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (($this->path() == 'product/store' || $this->path() == 'product/update') && (!(userSession()->hasRole('admin') || userSession()->hasPermissionTo('modify-products')))) {
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
        if ($this->path() == 'product/store') {
            return [
                'image' => "required|mimes:jpeg,png,jpg,gif,svg|max:2048",
                'name' => "required|string|unique:products,name|min:3",
                'description' => "required|string|min:4",
                'category_id' => "required|integer|exists:categories,id",
                'inventories' => "array",
                'inventories.*' => "integer|exists:inventories,id",
                'cost_price' => "required|numeric|min:1",
                'sales_price' => "required|numeric|min:1",
                'quantity' => "required|integer|min:0",
            ];
        }
        if ($this->path() == 'product/update') {
            return [
                'id' => "required|integer|exists:products,id",
                'image' => "nullable|mimes:jpeg,png,jpg,gif,svg|max:2048",
                'name' => "required|string|min:3|unique:products,name,".$this->id,
                'description' => "required|string|min:4",
                'category_id' => "required|integer|exists:categories,id",
                'inventories' => "array",
                'inventories.*' => "integer|exists:inventories,id",
                'cost_price' => "required|numeric|min:1",
                'sales_price' => "required|numeric|min:1",
                'quantity' => "required|integer|min:0",
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
            "image.mimes" => __("website.image_mimes"),
            "image.required" => __("website.image_required"),
            "description.required" => __("website.description_required"),
            "description.min" => __("website.description_min"),
            "category_id.required" => __("website.category_required"),
            "category_id.exists" => __("website.category_exists"),
            "inventories.array" => __("website.inventory_array"),
            "cost_price.required" => __("website.cost_price_required"),
            "cost_price.min" => __("website.cost_price_min"),
            "sales_price.required" => __("website.sales_price_required"),
            "sales_price.min" => __("website.sales_price_min"),
            "quantity.required" => __("website.quantity_required"),
            "quantity.min" => __("website.quantity_min"),
        ];
    }
    protected function failedAuthorization()
    {
        session::flash('is_authorized', 0);
    }
}
