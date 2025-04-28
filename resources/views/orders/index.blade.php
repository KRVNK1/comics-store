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
    <h1 class="text-2xl font-bold mb-6">
        @auth
            @if(auth()->user()->isAdmin())
                Управление заказами
            @else
                Мои заказы
            @endif
        @endauth
    </h1>

    @if($orders->isEmpty())
        <div class="bg-white rounded-lg shadow-sm p-6 text-center">
            <p class="text-gray-500">
                @auth
                    @if(auth()->user()->isAdmin())
                        Нет заказов
                    @else
                        У вас пока нет заказов
                    @endif
                @endauth
            </p>
            <a href="/" class="mt-4 inline-block px-4 py-2 bg-red-900 text-white rounded-md hover:bg-red-800">
                Перейти к покупкам
            </a>
        </div>
    @else
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Номер заказа</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата</th>
                        @auth
                            @if(auth()->user()->isAdmin())
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Клиент</th>
                            @endif
                        @endauth
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Сумма</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($orders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->order_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        @auth
                            @if(auth()->user()->isAdmin())
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->user->name }}<br>
                                    {{ $order->user->email }}
                                </td>
                            @endif
                        @endauth
                        <td class="px-6 py-4 whitespace-nowrap">
                            @auth
                                @if(auth()->user()->isAdmin())
                                    <form action="{{ route('orders.update-status', $order) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" 
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-900 focus:ring-red-900 text-sm">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>В обработке</option>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>В пути</option>
                                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Доставлен</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Отменен</option>
                                        </select>
                                    </form>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($order->status == 'completed') bg-green-100 text-green-800
                                        @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        @if($order->status == 'pending') В обработке
                                        @elseif($order->status == 'processing') В пути
                                        @elseif($order->status == 'completed') Доставлен
                                        @elseif($order->status == 'cancelled') Отменен
                                        @endif
                                    </span>
                                @endif
                            @endauth
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($order->total_amount, 0, ',', ' ') }} руб.</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('orders.show', $order) }}" class="text-red-900 hover:text-red-700">Подробнее</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
</body>
</html>