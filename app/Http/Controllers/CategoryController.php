<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $products = $category->products()->paginate(12); // 12 товаров на страницу
        
        return view('categories.show', compact('category', 'products'));
    }
}
