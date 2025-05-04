<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Детали заказа - COMICWERS</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/order-details.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ledger&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Шапка сайта -->
    @include('components.header')

    <!-- Основной контент -->
    <main class="container">
        <div class="order-container">
            <div class="order-header">
                <div class="">
                    <h1 class="order-title">Заказ {{ $order->order_number }}</h1>
                    <div class="order-date">Дата заказа: {{ $order->created_at->format('d.m.Y H:i') }}</div>
                </div>

                <div class="order-status">
                    <span class="status-badge status-{{ $order->status }}">
                        @if($order->status == 'processing')
                        В процессе
                        @elseif($order->status == 'completed')
                        Завершено
                        @elseif($order->status == 'canceled')
                        Отменено
                        @endif
                    </span>
                </div>

            </div>

            <div class="order-content">
                <div class="order-section">
                    <h2 class="section-title">Состав заказа</h2>
                    <div class="order-items">
                        @foreach($orderItems as $item)
                        <div class="order-item">
                            <div class="item-image">
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name_product }}">
                            </div>
                            <div class="item-details">
                                <h3 class="item-title">{{ $item->product->name_product }}</h3>
                                <div class="item-quantity">Количество: {{ $item->quantity }}</div>
                                <div class="item-price">{{ number_format($item->price, 0, ',', ' ') }} руб. за шт.</div>
                            </div>
                            <div class="item-total">{{ number_format($item->price * $item->quantity, 0, ',', ' ') }} руб.</div>
                        </div>
                        @endforeach
                    </div>
                    <div class="order-total">
                        <span>Итого</span>
                        <span>{{ number_format($order->total_amount, 0, ',', ' ') }} руб.</span>
                    </div>
                </div>

                <div class="order-section">
                    <h2 class="section-title">Информация о доставке</h2>
                    <div class="delivery-info">
                        <div class="info-row">
                            <span class="info-label">Адрес доставки</span>
                            <span class="info-value">{{ $order->shipping_address }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Телефон</span>
                            <span class="info-value">{{ $order->phone }}</span>
                        </div>
                        @if($order->notes)
                        <div class="info-row">
                            <span class="info-label">Комментарий</span>
                            <span class="info-value">{{ $order->notes }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="order-actions">
                <a href="{{ route('profile.show') }}#order-history" class="btn-back">← Вернуться в личный кабинет</a>
            </div>
        </div>
    </main>

    <!-- Подвал сайта -->
    @include('components.footer')
</body>

</html>