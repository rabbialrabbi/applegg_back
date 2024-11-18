<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
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
            'supplier_id' => 'required|exists:suppliers,supplier_id',
            'purchase_date' => 'required|date',
            'purchase_items' => 'required|array',
            'purchase_items.*.product_id' => 'required|exists:products,product_id',
            'purchase_items.*.quantity' => 'required|integer|min:1',
            'purchase_items.*.unit_price' => 'required|numeric|min:0',
        ];
    }
}
