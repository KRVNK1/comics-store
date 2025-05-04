<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Отображает список всех товаров.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(12);
        $categories = Category::all();
        
        // Проверяем, является ли пользователь администратором
        $isAdmin = auth()->check() && auth()->user()->role === 'admin';
        
        return view('products.index', compact('products', 'categories', 'isAdmin'));
    }

    /**
     * Отображает страницу отдельного товара.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $relatedProducts = Product::where('id_category', $product->id_category)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(5)
            ->get();
        
        // Проверяем, является ли пользователь администратором
        $isAdmin = auth()->check() && auth()->user()->role === 'admin';
        
        return view('products.show', compact('product', 'relatedProducts', 'isAdmin'));
    }

    /**
     * Отображает форму для создания нового товара.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Проверяем, является ли пользователь администратором
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'У вас нет доступа к этой странице');
        }
        
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Сохраняет новый товар в базе данных.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Проверяем, является ли пользователь администратором
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'У вас нет доступа к этой странице');
        }
        
        $request->validate([
            'name_product' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'id_category' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Обработка загрузки изображения
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->name_product) . '.' . $image->getClientOriginalExtension();
            // Сохраняем только имя файла без пути comics/
            $image->move(public_path('images/comics'), $imageName);
            $imagePath = $imageName; // Сохраняем только имя файла
        }

        // Создание товара
        Product::create([
            'name_product' => $request->name_product,
            'price' => $request->price,
            'id_category' => $request->id_category,
            'image' => $imagePath,
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Товар успешно добавлен');
    }

    /**
     * Отображает форму для редактирования товара.
     */
    public function edit(Product $product)
    {
        // Проверяем, является ли пользователь администратором
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'У вас нет доступа к этой странице');
        }
        
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Обновляет товар в базе данных.

     */
    public function update(Request $request, Product $product)
    {
        // Проверяем, является ли пользователь администратором
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'У вас нет доступа к этой странице');
        }
        
        $request->validate([
            'name_product' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'id_category' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Обработка загрузки изображения
        if ($request->hasFile('image')) {
            // Удаление старого изображение
            $oldImagePath = $product->image;
            // Проверка, на содержание "comics/"
            if (strpos($oldImagePath, 'comics/') === 0) {
                // Если да, то путь уже содержит "comics/"
                $fullPath = public_path('images/' . $oldImagePath);
            } else {
                // Если нет, то добавляем "comics/"
                $fullPath = public_path('images/comics/' . $oldImagePath);
            }
            
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->name_product) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/comics'), $imageName);
            
            // Сохраняем только имя файла
            $product->image = $imageName;
        }

        // Обновление товара
        $product->name_product = $request->name_product;
        $product->price = $request->price;
        $product->id_category = $request->id_category;
        $product->save();

        return redirect()->route('products.show', $product->id)
            ->with('success', 'Товар успешно обновлен');
    }

    /**
     * Удаляет товар из базы данных.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // Проверяем, является ли пользователь администратором
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'У вас нет доступа к этой странице');
        }
        
        // Удаляем изображение товара
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Товар успешно удален');
    }
}
