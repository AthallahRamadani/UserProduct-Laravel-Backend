<?php

namespace App\Http\Controllers\Api;

use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;



class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    //Create
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_product_id' => 'required|exists:category_products,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product = $this->productService->createProduct($request->all());

        return new ProductResource(true, 'Produk berhasil ditambahkan!', $product);
    }

    //Read
    public function index()
    {
        $product = $this->productService->getAll();

        return new ProductResource(true, 'List Data produk', $product);
    }

    //Read
    public function show($id)
    {
        $product = $this->productService->getOne($id);

        return new ProductResource(true, 'Data Produk Ditemukan!', $product);
    }

    //Update
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_product_id' => 'sometimes|required|exists:category_products,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product = $this->productService->getOne($id);

        if (!$product) {
            return response()->json(['error' => 'Produk tidak ditemukan'], 404);
        }

        $product = $this->productService->updateProduct($id, $request);

        return new ProductResource(true, 'Produk berhasil diperbarui!', $product);
    }

    //Delete
    public function destroy($id)
    {
        $product = $this->productService->getOne($id);

        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan!'], 404);
        }

        $this->productService->deleteProduct($product);

        return response()->json(['message' => 'Produk berhasil dihapus!'], 200);
    }
}
