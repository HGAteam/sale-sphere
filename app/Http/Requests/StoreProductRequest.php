<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255|unique:products,name',
            'brands' => 'required',
            'categories' => 'required',
            'barcode' => 'nullable|string|max:255',
            'description' => 'sometimes|string',
            'quantity' => 'required|numeric|min:1', // Debe ser mayor que 0
            'purchase_price' => 'required|numeric|min:0.01', // Debe ser mayor o igual a 0
            'selling_price' => 'required|numeric|min:0.01|gt:purchase_price', // Debe ser mayor que purchase_price
            'wholesale_price' => 'nullable|numeric|min:0.01|gte:purchase_price', // Debe ser mayor o igual a selling_price si está presente
            'unit' => 'required|string|max:255',
        ];
    }
}
