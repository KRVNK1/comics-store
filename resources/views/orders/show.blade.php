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
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Заголовок заказа -->
        <div class="px-6 py-4 bg-gray-50 border-b">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-bold text-gray-900">Заказ #{{ $order->order_number }}</h1>
                <span class="px-3 py-1 rounded-full text-sm font-medium 
                    @if($order->status == 'completed') bg-green-100 text-green-800
                    @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                    @else bg-yellow-100 text-yellow-800 @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            <p class="text-sm text-gray-500 mt-1">Дата заказа: {{ $order->created_at->format('d.m.Y H:i') }}</p>
        </div>

        <!-- Информация о заказе -->
        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Товары -->
                <div>
                    <h2 class="text-lg font-semibold mb-4">Состав заказа</h2>
                    <div class="divide-y divide-gray-200">
                        @foreach($order->items as $item)
                        <div class="py-4 flex justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-16 w-16">
                                    <img class="h-16 w-16 object-contain" src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name_product }}">
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $item->product->name_product }}</h3>
                                    <p class="text-sm text-gray-500">Количество: {{ $item->quantity }}</p>
                                    <p class="text-sm text-gray-500">{{ number_format($item->price, 0, ',', ' ') }} руб. за шт.</p>
                                </div>
                            </div>
                            <p class="text-sm font-medium text-gray-900">{{ number_format($item->price * $item->quantity, 0, ',', ' ') }} руб.</p>
                        </div>
                        @endforeach
                    </div>

                   <!-- В секции с итоговой суммой -->
<div class="border-t border-gray-200 mt-4 pt-4">
    @if($order->discount > 0)
    <div class="flex justify-between text-sm text-gray-700 mb-2">
        <p>Скидка ({{ $order->discount }}%)</p>
        <p>-{{ number_format($order->total_amount * $order->discount / (100 - $order->discount), 0, ',', ' ') }} руб.</p>
    </div>
    @endif
    <div class="flex justify-between text-base font-medium text-gray-900">
        <p>Итого</p>
        <p>{{ number_format($order->total_amount, 0, ',', ' ') }} руб.</p>
    </div>
</div>
                </div>

                <!-- Информация о доставке -->
                <div>
                    <h2 class="text-lg font-semibold mb-4">Информация о доставке</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Адрес доставки</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $order->shipping_address }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Телефон</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $order->phone }}</p>
                        </div>
                        @if($order->notes)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Примечания</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $order->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('orders.index') }}" class="text-red-900 hover:text-red-700 font-medium">
            &larr; Вернуться к списку заказов
        </a>
    </div>
</div>

</body>
</html>