<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_id' => $this->product_id,
            'name' => $this->name,
            'SKU' => $this->SKU,
            'price' => $this->price,
            'category' => $this->category?->name,
            'category_id' => $this->category_id,
            'initial_stock_quantity' => $this->initial_stock_quantity,
            'current_stock_quantity' => $this->current_stock_quantity,
        ];
    }
}
