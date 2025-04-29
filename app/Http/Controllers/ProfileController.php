<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Category;
use App\Models\Product;
use App\Models\Promocode;

class ProfileController extends Controller
{
    // Показ профиля
    public function show()
    {
        $user = Auth::user();
        $orders = $user->orders()->with('orderItems.product')->latest()->paginate(10);

        return view('profile.show', compact('user', 'orders'));
    }


    // Обновление профиля
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        $user->update($request->all());

        return back()->with('success', 'Профиль успешно обновлен');
    }

    // Смена пароля
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Проверяем, совпадает ли текущий пароль
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Текущий пароль неверен',
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Пароль успешно изменен');
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = $user->orders()->latest()->paginate(10);

        return view('profile.orders', compact('user', 'orders'));
    }

    // public function addCategory(Request $request)
    // {

    //     $request->validate([
    //         'name_category' => 'required|string|max:255|unique:categories',
    //     ]);

    //     Category::create([
    //         'name_category' => $request->name_category
    //     ]);

    //     return back()->with('success', 'Категория успешно добавлена');
    // }

    // public function addProduct(Request $request)
    // {
    //     $request->validate([
    //         'name_product' => 'required|string|max:255',
    //         'price' => 'required|numeric|min:0',
    //         'description' => 'required|string',
    //         'short_description' => 'required|string|max:255',
    //         'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'id_category' => 'required|exists:categories,id',
    //     ]);

    //     $imagePath = $request->file('image')->store('products', 'public');

    //     Product::create([
    //         'name_product' => $request->name_product,
    //         'price' => $request->price,
    //         'description' => $request->description,
    //         'short_description' => $request->short_description,
    //         'image' => $imagePath,
    //         'id_category' => $request->id_category,
    //     ]);

    //     return back()->with('success', 'Товар успешно добавлен');
    // }
}
