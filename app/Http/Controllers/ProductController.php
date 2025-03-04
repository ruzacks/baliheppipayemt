<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function indexAjax()
    {
        $products = Product::all();
        return $products;
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'sku' => 'required|string|max:255|unique:products,sku', // Fixed validation rule
            'image_url' => 'nullable|url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
        ]);

    
        $imagePath = null;
    
        if ($request->hasFile('image_file')) {
            // Store the uploaded file and get its path
            $imagePath = $request->file('image_file')->store('products', 'public');
        } elseif ($request->filled('image_url')) {
            // Use the provided URL
            $imagePath = $request->input('image_url');
        }
    
        // Create the product with the image path or URL
        Product::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'image_url' => $imagePath,
            'sku' => $request->input('sku'),
            'description' => $request->input('description'),
        ]);
    
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
            'image_url' => 'nullable',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
        ]);

        $imagePath = $product->image_url;

        if ($request->hasFile('image_file')) {
            // Store the uploaded file and get its path
            $imagePath = $request->file('image_file')->store('products', 'public');
        } elseif ($request->filled('image_url')) {
            // Use the provided URL
            $imagePath = $request->input('image_url');
        }

        // Update the product with the image path or URL
        $product->update([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'sku' => $request->input('sku'),
            'image_url' => $imagePath,
            'description' => $request->input('description'),
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function productList()
    {
        $products = Product::all(); // Customize the number of items per page
        return view('products.products', compact('products'));
    }

    public function singleProduct(Product $product)
    {
        return view('products.single-product', compact('product'));
    }
}
