<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Показать список заказов пользователя.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $orders = $user->isAdmin() 
            ? Order::with('user')->latest()->paginate(10)
            : $user->orders()->latest()->paginate(10);
        
        return view('orders.index', compact('orders'));
    }

    /**
     * Показать страницу оформления заказа.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function checkout()
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Ваша корзина пуста');
        }
        
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        
        return view('orders.checkout', compact('user', 'cartItems', 'totalPrice'));
    }

    /**
     * Сохранить новый заказ.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
        ]);
        
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Ваша корзина пуста');
        }
        
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        
        // Создаем заказ
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'total_amount' => $totalPrice,
            'status' => 'pending',
            'shipping_address' => $request->address,
            'phone' => $request->phone_number,
            'notes' => $request->comment,
        ]);
        
        // Создаем элементы заказа
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
            ]);
        }
        
        // Очищаем корзину
        $user->cartItems()->delete();
        
        return redirect()->route('orders.success', $order->id)->with('success', 'Заказ успешно оформлен');
    }

    
    public function success(Order $order)
    {
        // Проверяем, принадлежит ли заказ текущему пользователю
        if ($order->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            return redirect()->route('orders.index')->with('error', 'У вас нет доступа к этому заказу');
        }
        
        return view('orders.success', compact('order'));
    }

    
    public function show(Order $order)
    {
        // Проверяем, принадлежит ли заказ текущему пользователю или является ли пользователь администратором
        if ($order->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            return redirect()->route('orders.index')->with('error', 'У вас нет доступа к этому заказу');
        }
        
        $orderItems = $order->items()->with('product')->get();
        
        return view('orders.show', compact('order', 'orderItems'));
    }

    
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);
        
        $order->update([
            'status' => $request->status,
        ]);
        
        return back()->with('success', 'Статус заказа успешно обновлен');
    }
}
