<?php
namespace App\Repositories;

use App\Models\Supplier;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function create(array $data)
    {
        return Supplier::create($data);
    }

    public function update(int $id, array $data)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->update($data);
        return $supplier;
    }

    public function delete(int $id)
    {
        return Supplier::where('supplier_id', $id)->delete();
    }

    public function list(array $filters = [])
    {
        $itemPerPage = $filters['itemsPerPage']??10;

        $query = Supplier::query();

        if(!empty($filters['q'])){
            $key = $filters['q'];
            $query =  $query->where(function ($query) use ($key) {
                $query->where('name', 'like', '%'.$key.'%');
            })->orWhere(function ($query) use ($key) {
                $query->where('email', 'like', '%'.$key.'%');
            })->orWhere(function ($query) use ($key) {
                $query->where('phone', 'like', '%'.$key.'%');
            });
        }

        if (!empty($filters['sortBy'][0]) && !empty($filters['sortBy'][0]['key']) && !empty($filters['sortBy'][0]['order'])) {
            $sortBy = $filters['sortBy'][0]['key'];
            $orderBy = $filters['sortBy'][0]['order'];

            $query->orderBy($sortBy, $orderBy);
        }

        return $query->paginate($itemPerPage);
    }
}
