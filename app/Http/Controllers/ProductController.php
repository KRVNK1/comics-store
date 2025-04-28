<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// class ProductController extends Controller
// {
//     public function index(Request $request)
//     {
//         $categories = Category::all();
//         $selectedCategory = $request->input('category'); // Получаем выбранную категорию из запроса

//         if ($selectedCategory) {
//             $products = Product::where('id_category', $selectedCategory)->get(); // Получаем товары выбранной категории
//         } else {
//             $products = Product::all(); // Получаем все товары, если категория не выбрана
//         }

//         // return view('welcome', compact('categories', 'products', 'selectedCategory'));
//     }

//     public function show(Product $product)
//     {
//         $relatedProducts = Product::where('id_category', $product->id_category)
//             ->where('id', '!=', $product->id)
//             ->inRandomOrder()
//             ->limit(4)
//             ->get();

//         return view('products.show', compact('product', 'relatedProducts'));
//     }

//     // В ProductController.php

//     public function edit(Product $product)
//     {

//         $categories = Category::all();
//         return view('products.edit', compact('product', 'categories'));
//     }

//     public function update(Request $request, Product $product)
//     {


//         $request->validate([
//             'name_product' => 'required|string|max:255',
//             'price' => 'required|numeric|min:0',
//             'description' => 'required|string',
//             'short_description' => 'required|string|max:255',
//             'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
//             'id_category' => 'required|exists:categories,id',
//         ]);

//         $data = $request->all();

//         if ($request->hasFile('image')) {
//             // Удаляем старое изображение
//             if ($product->image) {
//                 Storage::disk('public')->delete($product->image);
//             }
//             $data['image'] = $request->file('image')->store('products', 'public');
//         }

//         $product->update($data);

//         return redirect()->route('products.show', $product)
//             ->with('success', 'Товар успешно обновлен');
//     }

//     public function destroy(Product $product)
//     {


//         if ($product->image) {
//             Storage::disk('public')->delete($product->image);
//         }

//         $product->delete();

//         return redirect()->route('home')
//             ->with('success', 'Товар успешно удален');
//     }
// }
