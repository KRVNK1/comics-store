<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Promocode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkout()
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Ваша корзина пуста');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('orders.checkout', compact('cartItems', 'total', 'user'));
    }

    public function placeOrder(Request $request)
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Ваша корзина пуста');
        }

        $request->validate([
            'phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'applied_promo' => 'nullable|string',
        ]);

        $originalTotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Проверяем промокод
        $total = $originalTotal;
        $promoApplied = false;
        $discountAmount = 0;
        
        if ($request->applied_promo) {
            $promocode = Promocode::where('code', strtoupper($request->applied_promo))->first();
            
            if ($promocode) {
                $discountAmount = $promocode->price;
                $total = max($originalTotal - $discountAmount, 0);
                $promoApplied = true;
            }
        }

        // Создаем заказ (без сохранения информации о промокоде)
        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $total, // Уже с учетом скидки
            'shipping_address' => $request->shipping_address,
            'phone' => $request->phone,
            'notes' => $request->notes,
        ]);

        // Добавляем товары в заказ
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        // Очищаем корзину
        $user->cartItems()->delete();

        $successMessage = 'Заказ успешно оформлен!';
        if ($promoApplied) {
            $successMessage .= " Применена скидка {$discountAmount} руб. по промокоду.";
        }

        return redirect()->route('orders.show', $order->id)
                         ->with('success', $successMessage);
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('orders.show', compact('order'));
    }

    public function index()
    {
        if (auth()->user()) {
            $orders = Order::latest()->get();
        } else {
            $orders = auth()->user()->orders()->latest()->get();
        }
        
        return view('orders.index', compact('orders'));
    }
    
    public function updateStatus(Request $request, Order $order)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
    
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);
    
        $order->update(['status' => $request->status]);
    
        return back()->with('success', 'Статус заказа обновлен');
    }

    
}