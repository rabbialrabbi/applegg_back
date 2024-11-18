<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 5; $i >= 0; $i--) {

            $date = Carbon::now()->subDays($i);

            for ($j = 1; $j <= 5; $j++){
                $suppler = Supplier::inRandomOrder()->first();
                $purchase = Purchase::create([
                    'supplier_id' => $suppler->supplier_id,
                    'supplier_name' => $suppler->name,
                    'total_amount' => 0,
                    'purchase_date' => $date,
                ]);


                $purchaseItem = mt_rand(2, 10);

                $totalAmount = 0;
                for ($k = 1; $k <= $purchaseItem; $k++) {
                    $product = Product::inRandomOrder()->first();
                    $quantity = mt_rand(1, 10);
                    $unitPrice = $product->price + mt_rand(10, 100);
                    $totalPrice = $quantity * $unitPrice;
                    $totalAmount += $totalPrice;
                    PurchaseItem::create([
                        'purchase_id' => $purchase->purchase_id,
                        'product_id' => $product->product_id,
                        'product_name' => $product->name,
                        'quantity' => $quantity,
                        'unit_price' =>$unitPrice,
                        'total_price' => $totalAmount,
                    ]);
                }

                $purchase->update(['total_amount' => $totalAmount]);
            }


        }
    }
}
