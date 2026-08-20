<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // For Admin: show all categories
    public function index()
    {
        $categories = \App\Models\Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    // For Admin: show form to create category
    public function create()
    {
        return view('admin.categories.create');
    }

    // For Admin: store new category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'pet_type' => 'required|in:dog,cate',
        ]);

        Category::create([
            'name' =>$request->name,
            'pet_type' => $request->pet_type,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }
    
    // For Admin: show form to edit category
    public function edit(Category $category)
    {
        return view ('admin.categories.edit', compact('category'));
    }

    // For Admin: update category
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'pet_type' => 'required|in:dog,cat',
        ]);

        $category->update([
            'name' => $request->name,
            'pet_type' => $request->pet_type,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    // For Admin: delete category
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }

}
