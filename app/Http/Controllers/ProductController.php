<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
    {
    // Show all products on homepage
    public function index(Request $request)
    {
        $query = Product::with('category')->where('status', 'active');


        // Filter by pet type
        if ($request->pet_type) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('pet_type', $request->pet_type);
            });
        }
        
        // Filter by category
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Search by name
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);
        $categories = Category::all();

        return view('home', compact('products', 'categories'));
    }

    // Show single product
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // For Admin: shoow form to create product
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // For Admin: store new product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'price'=> 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:active, archived',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.dashboard')->with('success', 'Product added successfully');
        }

        // For Admin: show form to edit product
        public function edit(Request $request, Product $product)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required',
                'category_id' => 'required|exists:categories,id',
                'price'=> 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'status' => 'required|in:active, archived',
            ]);

            $data = $request->all();

            if ($request->hasFile('image')){
                $data['image'] = $request->file('image')->store('products', 'public');
            }

            $product->update($data);

            return redirect()->route('admin.dashboard')->with('success', 'Product updated successfully');
        }

        // Fro Admin: delete product
        public function destroy(Product $product)
        {
            $product->delete();
            return redirect()->route('admin.dashboard')->with('success', 'Product deleted successfully.');
        }
    }



