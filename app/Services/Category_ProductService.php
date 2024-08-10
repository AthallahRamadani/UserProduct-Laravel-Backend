<?php
namespace App\Services;

use App\Models\Category_Product;

class Category_ProductService
{
    public function getAll() {
        return Category_Product::oldest()->paginate(10);
    }

    public function createCategory(array $data)
    {
        return Category_Product::create($data);
    }


    public function getOne($id) {
        return Category_Product::find($id);
    }

    public function updateCategory($id, array $data)
    {
        $category = Category_Product::find($id);
        if ($category) {
            $category->update($data);
            return $category;
        }
        return null;
    }

    public function deleteCategory(Category_Product $category)
    {
        $category->delete();
    }
}