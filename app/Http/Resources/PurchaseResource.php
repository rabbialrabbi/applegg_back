<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'purchase_id' => $this->purchase_id,
            'supplier' => $this->supplier_name,
            'total_amount' => $this->total_amount,
            'purchase_date' => $this->purchase_date,
            'purchase_items' => PurchaseItemResource::collection($this->purchaseItems),
        ];
    }
}
