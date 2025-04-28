<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_product',
        'price',
        'image',
        'id_category'
    ];

    
    // Получить категорию, к которой принадлежит товар.
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    // Получить элементы заказа для этого товара.
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'id_product');
    }

    // Получить элементы корзины для этого товара.
    public function cartItems()
    {
        return $this->hasMany(Cart::class, 'id_product');
    }
}