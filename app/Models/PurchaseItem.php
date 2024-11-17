<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    /** @use HasFactory<\Database\Factories\PurchaseItemFactory> */
    use HasFactory;

    protected $primaryKey = 'purchase_items_id';
    protected $fillable = [
        'purchase_items_id',
        'purchase_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price',
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
