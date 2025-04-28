<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $categories = Category::all();

        $products = $category->products()->paginate(12); // 12 товаров на страницу
        
        return view('categories.show', compact('category', 'products', 'categories'));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }
    
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name_category' => 'required|string|max:255|unique:categories,name_category,' . $category->id,
        ]);

        $category->update([
            'name_category' => $request->name_category,
        ]);

        return redirect()->route('categories.index')->with('success', 'Категория успешно обновлена');
    }

    public function destroy(Category $category)
    {        
        $category->delete();
        
        return redirect()->route('categories.index')->with('success', 'Категория успешно удалена');
    }
}
