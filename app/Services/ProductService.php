<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class ProductService
{
    public function getAll()
    {
        return Product::oldest()->paginate(10);
    }

    public function createProduct(array $data)
    {
        $image = $data['image'];
        $imageName = $image->hashName();
        $image->storeAs('public/products', $imageName);

        return Product::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'image' => $imageName,
            'category_product_id' => $data['category_product_id'],
        ]);
    }

    public function getOne($id)
    {
        return Product::find($id);
    }

    public function updateProduct($id, Request $request)
    {
        $product = Product::find($id);

        if (!$product) {
            return null;
        }

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete('public/products/' . $product->image);
            }

            $imagePath = $request->file('image')->store('public/products');
            $data['image'] = basename($imagePath);
        }

        $product->update($data);

        return $product;
    }

    public function deleteProduct(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete('products/' . $product->image);
        }

        $product->delete();
    }
}
