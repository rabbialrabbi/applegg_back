<?php
namespace App\Repositories;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;

class PurchaseRepository implements PurchaseRepositoryInterface
{
    public function createPurchase(array $data)
    {
        return \DB::transaction(function () use ($data) {
            $supplier = Supplier::findOrfail($data['supplier_id']);
            $purchase = Purchase::create([
                'supplier_id' => $data['supplier_id'],
                'supplier_name' => $supplier->name,
                'total_amount' => $data['total_amount'],
                'purchase_date' => $data['purchase_date'],
            ]);

            foreach ($data['purchase_items'] as $item) {
                $product = Product::findOrfail($item['product_id']);
                $purchaseItem = new PurchaseItem([
                    'product_id' => $item['product_id'],
                    'product_name' => $product->name,
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
                $query->where('purchase_id', 'like', '%'.$key.'%');
            })->orWhere(function ($query) use ($key) {
                $query->where('total_amount', 'like', '%'.$key.'%');
            })->orWhere(function ($query) use ($key) {
                $query->where('purchase_date', 'like', '%'.$key.'%');
            })->orWhere(function ($query) use ($key) {
                $query->where('supplier_name', 'like', '%'.$key.'%');
            });
        }
        if (!empty($filters['sortBy'][0]) && !empty($filters['sortBy'][0]['key']) && !empty($filters['sortBy'][0]['order'])) {
            $sortBy = $filters['sortBy'][0]['key'];
            $orderBy = $filters['sortBy'][0]['order'];
            if ($sortBy == 'supplier') {
                $sortBy = 'supplier_name';
            }
            $query->orderBy($sortBy, $orderBy);
        }

        return $query->paginate($itemPerPage);
    }
}
