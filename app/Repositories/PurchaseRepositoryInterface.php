<?php
namespace App\Repositories;

interface PurchaseRepositoryInterface
{
    public function createPurchase(array $data);
    public function listPurchases(array $filters = []);
}
