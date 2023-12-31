<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $categories = Category::orderBy('id', 'asc')->paginate(10);
        return view('category.index', compact('categories'));
    }

    public function show(Category $category)
    {
        return view('category.show', compact('category'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:16',
        ]);
        $category = new Category();
        $category->name = $request->input('name');
        $category->save();
        return redirect()->back()->with('success', 'Category created successfully!');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:16',
        ]);

        $category->update($request->all());
        return redirect()->back()->with('success', 'Category updated successfully!');
    }

    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }
}
