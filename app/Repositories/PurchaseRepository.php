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

    public function listPurchases(array $filters = [])
    {
        $itemPerPage = $filters['itemsPerPage']??10;
        $query = Purchase::with(['supplier']);

        if(!empty($filters['q'])){
            $key = $filters['q'];
            $query =  $query->where(function ($query) use ($key) {
                $query->where('name', 'like', '%'.$key.'%');
            })->orWhere(function ($query) use ($key) {
                $query->whereHas('supplier',function ($query) use($key){
                    $query->where('name', 'like', '%'.$key.'%');
                });
            });
        }
        if (!empty($filters['sortBy'][0]) && !empty($filters['sortBy'][0]['key']) && !empty($filters['sortBy'][0]['order'])) {
            $sortBy = $filters['sortBy'][0]['key'];
            $orderBy = $filters['sortBy'][0]['order'];
            if ($sortBy == 'supplier') {
                $query->join('suppliers', 'suppliers.supplier_id', '=', 'purchases.supplier_id')
                    ->orderBy('suppliers.name', $orderBy);

            } else {
                $query->orderBy($sortBy, $orderBy);
            }
        }

        return $query->paginate($itemPerPage);
    }
}
