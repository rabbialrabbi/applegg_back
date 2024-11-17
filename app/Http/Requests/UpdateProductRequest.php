<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string',
            'SKU'=> [
                'required',
                Rule::unique('products')->ignore($this->id,'product_id'),
            ],
            'price' => 'sometimes|numeric|min:0',
            'initial_stock_quantity' => 'sometimes|integer|min:0',
            'category_id' => 'nullable|exists:categories',
        ];
    }
}
