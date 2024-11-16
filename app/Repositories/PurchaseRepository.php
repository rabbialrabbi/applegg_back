<?php
namespace App\Repositories;

use App\Models\Purchase;
use App\Models\PurchaseItem;

class PurchaseRepository implements PurchaseRepositoryInterface
{
    public function createPurchase(array $data)
    {
        return \DB::transaction(function () use ($data) {
            $purchase = Purchase::create([
                'supplier_id' => $data['supplier_id'],
                'total_amount' => $data['total_amount'],
                'purchase_date' => $data['purchase_date'],
            ]);

            foreach ($data['items'] as $item) {
                $purchaseItem = new PurchaseItem([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['quantity'] * $item['unit_price'],
                ]);
                $purchase->purchaseItems()->save($purchaseItem);

                $product = $purchaseItem->product;
                $product->current_stock_quantity += $item['quantity'];
                $product->save();
            }

            return $purchase;
        });
    }

    public function listPurchases()
    {
        return Purchase::with(['supplier', 'purchaseItems.product'])->paginate(10);
    }
}
