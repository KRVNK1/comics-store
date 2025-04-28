<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(12);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_product' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_category' => 'required|exists:categories,id',
        ]);

        // Сохраняем изображение
        $imagePath = $request->file('image')->store('comics', 'public');

        Product::create([
            'name_product' => $request->name_product,
            'price' => $request->price,
            'image' => $imagePath,
            'id_category' => $request->id_category,
        ]);

        return redirect()->route('profile.show')->with('success', 'Товар успешно добавлен');
    }

    
    public function show(Product $product)
    {
        // Получаем рекомендуемые товары из той же категории
        $recommendedProducts = Product::where('id_category', $product->id_category)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(5)
            ->get();
        
        return view('products.show', compact('product', 'recommendedProducts'));
    }

    
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

   
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name_product' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_category' => 'required|exists:categories,id',
        ]);

        $data = [
            'name_product' => $request->name_product,
            'price' => $request->price,
            'id_category' => $request->id_category,
        ];

        // Если загружено новое изображение
        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            // Сохраняем новое изображение
            $data['image'] = $request->file('image')->store('comics', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Товар успешно обновлен');
    }

    
    public function destroy(Product $product)
    {
        // Удаляем изображение
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();
        
        return redirect()->route('products.index')->with('success', 'Товар успешно удален');
    }
}