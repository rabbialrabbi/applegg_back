<?php
namespace App\Services;

use App\Repositories\PurchaseRepository;

class PurchaseService
{
    protected $purchaseRepository;

    public function __construct(PurchaseRepository $purchaseRepository)
    {
        $this->purchaseRepository = $purchaseRepository;
    }

    public function createPurchase(array $data)
    {
        $totalAmount = 0;
        foreach ($data['items'] as $item) {
            $totalAmount += $item['quantity'] * $item['unit_price'];
        }
        $data['total_amount'] = $totalAmount;

        return $this->purchaseRepository->createPurchase($data);
    }

    public function  listPurchases(array $filters = [])
    {
        return $this->purchaseRepository->listPurchases($filters);
    }
}
