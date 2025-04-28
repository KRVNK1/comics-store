<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        // Получаем популярные товары (можно реализовать логику популярности по заказам)
        // Пока просто берем первые 5 товаров
        $popularProducts = Product::inRandomOrder()->take(5)->get();

        // Получаем новые поступления (последние добавленные товары)
        $newProducts = Product::latest()->take(5)->get();

        return view('welcome', compact('categories', 'popularProducts', 'newProducts'));
    }
}
