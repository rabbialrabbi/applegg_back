<?php
namespace App\Repositories;

use App\Models\Category;
use App\Models\Product;

class CategoryRepository implements CategoryRepositoryInterface
{
        public function list(array $filters = [])
    {
        return Category::all();
    }
}
