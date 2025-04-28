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
        $promocodes = [];

        if ($user->status_user == 1) {
            $promocodes = Promocode::all();
        }

        return view('profile.show', [
            'user' => $user,
            'promocodes' => $promocodes
        ]);
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
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Пароль успешно изменен!');
    }

    private function checkAdmin()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Доступ запрещен');
        }
    }

    public function addCategory(Request $request)
    {
        $this->checkAdmin();

        $request->validate([
            'name_category' => 'required|string|max:255|unique:categories',
        ]);

        Category::create([
            'name_category' => $request->name_category
        ]);

        return back()->with('success', 'Категория успешно добавлена');
    }

    public function addProduct(Request $request)
    {
        $this->checkAdmin();

        $request->validate([
            'name_product' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'short_description' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_category' => 'required|exists:categories,id',
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            'name_product' => $request->name_product,
            'price' => $request->price,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'image' => $imagePath,
            'id_category' => $request->id_category,
        ]);

        return back()->with('success', 'Товар успешно добавлен');
    }
}
