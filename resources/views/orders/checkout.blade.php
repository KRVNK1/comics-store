<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформление заказа - COMICWERS</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ledger&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Шапка сайта -->
    @include('components.header')

    <!-- Основной контент -->
    <main class="container">
        <h1 class="page-title">Оформление заказа</h1>

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('orders.store') }}" method="POST" class="checkout-form">
            @csrf
            <div class="checkout-container">
                <!-- Левая колонка - Товары -->
                <div class="checkout-products">
                    <div class="checkout-header">
                        <div class="checkout-header-product">Продукт</div>
                        <div class="checkout-header-price">Цена</div>
                        <div class="checkout-header-quantity">Кол-во</div>
                        <div class="checkout-header-total">Всего</div>
                    </div>

                    @foreach($cartItems as $item)
                    <div class="checkout-item">
                        <div class="checkout-item-product">
                            <div class="checkout-item-image">
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name_product }}">
                            </div>
                            <div class="checkout-item-details">
                                <h3 class="checkout-item-title">{{ $item->product->name_product }}</h3>
                            </div>
                        </div>
                        <div class="checkout-item-price">{{ number_format($item->product->price, 0, ',', ' ') }} руб.</div>
                        <div class="checkout-item-quantity">
                            <div class="quantity-control">
                                <button type="button" class="quantity-btn quantity-decrease" disabled>−</button>
                                <span class="quantity-value">{{ $item->quantity }}</span>
                                <button type="button" class="quantity-btn quantity-increase" disabled>+</button>
                            </div>
                        </div>
                        <div class="checkout-item-total">{{ number_format($item->product->price * $item->quantity, 0, ',', ' ') }} руб.</div>
                    </div>
                    @endforeach
                </div>

                <!-- Правая колонка - Форма доставки -->
                <div class="checkout-delivery">
                    <h2 class="section-title">Данные для доставки</h2>
                    
                    <div class="form-group">
                        <label for="phone">Телефон</label>
                        <input type="tel" id="phone" name="phone_number" value="{{ old('phone_number', $user->phone ?? '') }}" class="form-input" required>
                        @error('phone_number')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Адрес доставки</label>
                        <input type="text" id="address" name="address" value="{{ old('address', $user->address ?? '') }}" class="form-input" required>
                        @error('address')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="comment">Комментарий к заказу</label>
                        <textarea id="comment" name="comment" class="form-input form-textarea">{{ old('comment') }}</textarea>
                    </div>
                    
                    <div class="checkout-summary">
                        <div class="summary-row">
                            <span>Товары ({{ $cartItems->sum('quantity') }})</span>
                            <span>{{ number_format($totalPrice, 0, ',', ' ') }} руб.</span>
                        </div>
                        
                        <div class="summary-row">
                            <span>Доставка</span>
                            <span>Бесплатно</span>
                        </div>
                        
                        <div class="summary-total">
                            <span>Итого к оплате</span>
                            <span>{{ number_format($totalPrice, 0, ',', ' ') }} руб.</span>
                        </div>
                    </div>
                    <div class="btn" style="padding: 0px 20px 20px;">
                        <button type="submit" class="btn-confirm">Подтвердить</button>
                    </div>
                </div>
            </div>
        </form>

    </main>

    <!-- Подвал сайта -->
    @include('components.footer')
</body>
</html>
