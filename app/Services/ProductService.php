<?php
namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function createProduct(array $data)
    {
        $data['current_stock_quantity'] = $data['initial_stock_quantity'];
        return $this->productRepository->create($data);
    }

    public function updateProduct(int $id, array $data)
    {
        $data['current_stock_quantity'] = $data['initial_stock_quantity'];
        return $this->productRepository->update($id, $data);
    }

    public function deleteProduct(int $id)
    {
        return $this->productRepository->delete($id);
    }

    public function listProducts(array $filters = [])
    {
        return $this->productRepository->list($filters);
    }
}
