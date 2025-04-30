<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'id_product' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->id_product);
        
        $cartItem = Cart::firstOrNew([
            'user_id' => auth()->id(),
            'product_id' => $product->id
        ]);

        $cartItem->quantity = isset($cartItem->quantity) ? $cartItem->quantity + 1 : 1;
        $cartItem->save();

        return back()->with('success', 'Товар добавлен в корзину');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:cart,id',
        ]);
        
        $cartItem = Cart::findOrFail($request->id);
        
        // Проверяем, принадлежит ли элемент корзины текущему пользователю
        if ($cartItem->user_id !== auth()->id()) {
            return redirect()->route('cart.index')->with('error', 'Вы не можете удалить этот элемент корзины');
        }
        
        $cartItem->delete();
        
        return redirect()->route('cart.index')->with('success', 'Товар удален из корзины');
    }

    public function index()
    {
        $cartItems = auth()->user()->cartItems()->with('product')->get();
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        
        // Получаем рекомендуемые товары
        $recommendedProducts = Product::inRandomOrder()->take(5)->get();
        
        return view('cart.index', compact('cartItems', 'totalPrice', 'recommendedProducts'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:cart,id',
            'action' => 'required|in:increase,decrease',
        ]);
        
        $cartItem = Cart::findOrFail($request->id);
        
        // Проверяем, принадлежит ли элемент корзины текущему пользователю
        if ($cartItem->user_id !== auth()->id()) {
            return redirect()->route('cart.index')->with('error', 'Вы не можете изменить этот элемент корзины');
        }
        
        // Увеличиваем или уменьшаем количество в зависимости от действия
        if ($request->action === 'increase') {
            $cartItem->quantity += 1;
        } else {
            $cartItem->quantity = max(1, $cartItem->quantity - 1);
        }
        
        $cartItem->save();
        
        return redirect()->route('cart.index');
    }

    public function clear()
    {
        auth()->user()->cartItems()->delete();
        
        return redirect()->route('cart.index')->with('success', 'Корзина очищена');
    }

    /**
     * Добавить товар в корзину повторно (из истории заказов).
     *
     * @param  \App\Models\Product  $product
     * @param  int  $quantity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addAgain(Product $product, $quantity)
    {
        $cartItem = Cart::firstOrNew([
            'user_id' => auth()->id(),
            'product_id' => $product->id
        ]);

        $cartItem->quantity = isset($cartItem->quantity) ? $cartItem->quantity + $quantity : $quantity;
        $cartItem->save();
        
        return redirect()->route('cart.index')->with('success', 'Товар добавлен в корзину');
    }
}
