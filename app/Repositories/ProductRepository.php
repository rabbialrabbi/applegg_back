<?php
namespace App\Repositories;

use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(int $id, array $data)
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product;
    }

    public function delete(int $id)
    {
        return Product::where('product_id', $id)->delete();
    }

    public function list(array $filters = [])
    {

        $itemPerPage = $filters['itemsPerPage']??10;
        $query = Product::with(['category']);

        if(!empty($filters['q'])){
            $key = $filters['q'];
            $query =  $query->where(function ($query) use ($key) {
                $query->where('name', 'like', '%'.$key.'%');
            })->orWhere(function ($query) use ($key) {
                $query->whereHas('category',function ($query) use($key){
                    $query->where('name', 'like', '%'.$key.'%');
                });
            })->orWhere(function ($query) use ($key) {
                $query->where('sku', 'like', '%'.$key.'%');
            });
        }

        if (!empty($filters['sortBy'][0]) && !empty($filters['sortBy'][0]['key']) && !empty($filters['sortBy'][0]['order'])) {
            $sortBy = $filters['sortBy'][0]['key'];
            $orderBy = $filters['sortBy'][0]['order'];
            if ($sortBy == 'category') {
                $query->join('category', 'categories.category_id', '=', 'products.category_id')
                    ->orderBy('customers.name', $orderBy);

            } else {
                $query->orderBy($sortBy, $orderBy);
            }
        }

        return $query->paginate($itemPerPage);
    }
}
