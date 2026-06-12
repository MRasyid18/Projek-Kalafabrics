<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('active', true)->with('category');

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->has('product_type')) {
            $query->where('product_type', 'like', '%' . $request->product_type . '%');
        }

        $products = $query->paginate(15);

        return ProductResource::collection($products);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products',
            'description' => 'required|string',
            'environmental_impact' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products',
            'image_path' => 'nullable|string',
            'points_reward' => 'integer|min:0',
            'product_type' => 'in:b2c,b2b,both',
            'bulk_discount_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $product = Product::create($validated);

        return new ProductResource($product);
    }

    public function show(Product $product)
    {
        return new ProductResource($product->load('category'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'exists:categories,id',
            'name' => 'string|max:255',
            'slug' => 'string|unique:products,slug,' . $product->id,
            'description' => 'string',
            'environmental_impact' => 'nullable|string',
            'price' => 'numeric|min:0',
            'stock' => 'integer|min:0',
            'sku' => 'string|unique:products,sku,' . $product->id,
            'image_path' => 'nullable|string',
            'points_reward' => 'integer|min:0',
            'product_type' => 'in:b2c,b2b,both',
            'bulk_discount_percentage' => 'nullable|numeric|min:0|max:100',
            'active' => 'boolean',
        ]);

        $product->update($validated);

        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
