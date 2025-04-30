<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Магазин часов</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ledger&display=swap" rel="stylesheet">
</head>


<body>

    @include('components.header')

    <div class="container">
        <h1 class="profile-title">Настройки учетной записи</h1>

        <div class="profile-tabs">
            <a href="{{ route('profile.show') }}" class="profile-tab">Информация профиля</a>
            <a href="{{ route('orders.index') }}" class="profile-tab active">История заказов</a>
        </div>

        <div class="profile-content">
            <h2 class="profile-section-title">История заказов</h2>

            @if($orders->isEmpty())
            <div class="empty-orders">
                <p>У вас пока нет заказов</p>
                <a href="{{ route('home') }}" class="profile-link">Перейти к покупкам</a>
            </div>
            @else
            <div class="orders-list">
                @foreach($orders as $order)
                <div class="order-item">
                    <div class="order-header">
                        <div class="order-info">
                            <span class="order-number">Заказ #{{ $order->id }}</span>
                            <span class="order-date">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        <div class="order-status">
                            <span class="status-badge status-{{ $order->status }}">{{ $order->status_text }}</span>
                        </div>
                    </div>

                    <div class="order-products">
                        @foreach($order->orderItems as $item)
                        <div class="order-product">
                            <div class="product-image">
                                <img src="{{ asset('images/' . $item->product->image) }}" alt="{{ $item->product->name_product }}">
                            </div>
                            <div class="product-details">
                                <h3 class="product-title">{{ $item->product->name_product }}</h3>
                                <div class="product-meta">
                                    <span class="product-price">{{ number_format($item->price, 0, ',', '.') }} руб.</span>
                                    <span class="product-quantity">x {{ $item->quantity }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="order-footer">
                        <div class="order-total">
                            <span>Итого:</span>
                            <span class="total-price">{{ number_format($order->total_price, 0, ',', '.') }} руб.</span>
                        </div>
                        <a href="{{ route('orders.show', $order->id) }}" class="order-details-btn">Подробнее</a>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="pagination">
                {{ $orders->links() }}
            </div>
            @endif
        </div>
    </div>

    @include('components.footer')


</body>

</html>