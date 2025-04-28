<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Магазин часов</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<style>
    body {
    font-family: 'Nunito', sans-serif;
}
</style>
<body class="bg-white text-gray-800">

@include('components.header')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-6">Корзина</h1>

    @if($cartItems->isEmpty())
        <div class="bg-white rounded-lg shadow-sm p-6 text-center">
            <p class="text-gray-500">Ваша корзина пуста</p>
            <a href="/" class="mt-4 inline-block px-4 py-2 bg-red-900 text-white rounded-md hover:bg-red-800">
                Перейти к покупкам
            </a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Товар</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Цена</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Количество</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Итого</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($cartItems as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 object-contain" src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name_product }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->product->name_product }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ number_format($item->product->price, 0, ',', ' ') }} руб.
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item->quantity }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ number_format($item->product->price * $item->quantity, 0, ',', ' ') }} руб.
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <form action="{{ route('cart.remove', $item->product) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-red-900 hover:text-red-700">Удалить</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="px-6 py-4 bg-gray-50 border-t flex justify-between items-center">
                <div class="text-xl font-semibold">Итого: {{ number_format($total, 0, ',', ' ') }} руб.</div>
                <a href="{{ route('orders.checkout') }}" class="px-4 py-2 bg-red-900 text-white rounded-md hover:bg-red-800">
    Оформить заказ
</a>
            </div>
        </div>
    @endif
</div>
</body>
</html>