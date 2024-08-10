<?php

namespace App\Http\Controllers\Api;

use App\Services\Category_ProductService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category_ProductResource;
use Illuminate\Support\Facades\Validator;

class Category_ProductController extends Controller
{
    protected $category_ProductService;

    public function __construct(Category_ProductService $Category_ProductService)
    {
        $this->category_ProductService = $Category_ProductService;
    }

    public function index()
    {

        $category = $this->category_ProductService->getAll();

        return new Category_ProductResource(true, 'List Data Kategori', $category);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category = $this->category_ProductService->createCategory($request->all());

        return new Category_ProductResource(true, 'Kategori berhasil ditambahkan!', $category);
    }

    public function show($id)
    {
        $category = $this->category_ProductService->getOne($id);

        return new Category_ProductResource(true, 'Data Kategori Ditemukan!', $category);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category = $this->category_ProductService->updateCategory($id, $request->all());

        if (!$category) {
            return response()->json(['message' => 'Kategori tidak ditemukan!'], 404);
        }

        return new Category_ProductResource(true, 'Kategori berhasil diperbarui!', $category);
    }

    public function destroy($id)
    {
        $category = $this->category_ProductService->getOne($id);

        if (!$category) {
            return response()->json(['message' => 'Kategori tidak ditemukan!'], 404);
        }

        $this->category_ProductService->deleteCategory($category);

        return response()->json(['message' => 'Kategori berhasil dihapus!'], 200);
    }
}
