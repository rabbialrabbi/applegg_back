<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory,SoftDeletes;
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'name',
        'SKU',
        'price',
        'category_id',
        'initial_stock_quantity',
        'current_stock_quantity',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','category_id');
    }
}
