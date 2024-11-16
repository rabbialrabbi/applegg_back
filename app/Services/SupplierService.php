<?php
namespace App\Services;

use App\Repositories\SupplierRepository;

class SupplierService
{
    protected $supplierRepository;

    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    public function createSupplier(array $data)
    {
        return $this->supplierRepository->create($data);
    }

    public function updateSupplier(int $id, array $data)
    {
        return $this->supplierRepository->update($id, $data);
    }

    public function deleteSupplier(int $id)
    {
        return $this->supplierRepository->delete($id);
    }

    public function listSuppliers(array $filters = [])
    {
        return $this->supplierRepository->list($filters);
    }
}
