<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Product $product)
    {
        $cartItem = Cart::firstOrNew([
            'user_id' => auth()->id(),
            'product_id' => $product->id
        ]);

        $cartItem->quantity += 1;
        $cartItem->save();

        return back()->with('success', 'Товар добавлен в корзину');
    }

    public function remove(Product $product)
    {
        Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->delete();

        return back()->with('success', 'Товар удален из корзины');
    }

    public function index()
    {
        $cartItems = auth()->user()->cartItems()->with('product')->get();
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }
}