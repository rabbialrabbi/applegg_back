<?php
namespace App\Repositories;

interface SupplierRepositoryInterface
{
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function list(array $filters = []);
}