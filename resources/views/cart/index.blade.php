<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина - COMICWERS</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ledger&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Шапка сайта -->
    @include('components.header')

    <!-- Основной контент -->
    <main class="container">
        <h1 class="page-title">Корзина</h1>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
        @endif

        @if($cartItems->isEmpty())
        <div class="empty-cart">
            <div class="empty-cart-icon">
                <span>
                    <img src="{{ asset('images/svg/Cart.svg') }}" alt="">
                </span>
            </div>
            <p>Ваша корзина пуста</p>
            <a href="{{ route('home') }}" class="btn-primary">Перейти к покупкам</a>
        </div>
        @else
        <div class="cart-container">
            <div class="cart-items">
                <div class="cart-header">
                    <div class="cart-header-product">Продукт</div>
                    <div class="cart-header-price">Цена</div>
                    <div class="cart-header-quantity">Кол-во</div>
                    <div class="cart-header-total">Всего</div>
                    <div class="cart-header-action"></div>
                </div>

                @foreach($cartItems as $item)
                <div class="cart-item">
                    <div class="cart-item-product">
                        <div class="cart-item-image">
                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name_product }}">
                        </div>
                        <div class="cart-item-details">
                            <h3 class="cart-item-title">{{ $item->product->name_product }}</h3>
                        </div>
                    </div>
                    <div class="cart-item-price">{{ number_format($item->product->price, 0, ',', ' ') }} руб.</div>
                    <div class="cart-item-quantity">
                        <form action="{{ route('cart.update') }}" method="POST" class="quantity-form">
                            @csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <div class="quantity-control">
                                <button type="button" class="quantity-btn quantity-decrease">−</button>
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="quantity-input" readonly>
                                <button type="button" class="quantity-btn quantity-increase">+</button>
                            </div>
                        </form>
                    </div>
                    <div class="cart-item-total">{{ number_format($item->product->price * $item->quantity, 0, ',', ' ') }} руб.</div>
                    <div class="cart-item-action">
                        <form action="{{ route('cart.remove') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <button type="submit" class="remove-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="cart-summary">
                <h2 class="summary-title">Итого</h2>

                <div class="summary-row">
                    <span>Товары ({{ $cartItems->sum('quantity') }})</span>
                    <span>{{ number_format($totalPrice, 0, ',', ' ') }} руб.</span>
                </div>

                <div class="summary-total">
                    <span>Итого к оплате</span>
                    <span>{{ number_format($totalPrice, 0, ',', ' ') }} руб.</span>
                </div>

                <div class="summary-actions">
                    <a href="{{ route('orders.checkout') }}" class="btn-checkout">Оформить заказ</a>
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-clear-cart">Очистить корзину</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Рекомендуемые товары -->
        <div class="recommended-section">
            <h2 class="section-title">Вам также может понравиться</h2>
            <div class="product-grid">
                @foreach($recommendedProducts as $product)
                <div class="product-card">
                    <a href="{{ route('products.show', $product->id) }}">
                        <div class="product-image">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name_product }}">
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">{{ $product->name_product }}</h3>
                            <p class="product-price">{{ number_format($product->price, 0, ',', ' ') }} руб.</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </main>

    <!-- Подвал сайта -->
    @include('components.footer')

    <!-- Подключаем JavaScript -->
    <script>
        // Ждем, пока страница полностью загрузится
        document.addEventListener("DOMContentLoaded", () => {
            // Находим все кнопки уменьшения и увеличения количества
            const decreaseBtns = document.querySelectorAll(".quantity-decrease")
            const increaseBtns = document.querySelectorAll(".quantity-increase")

            // Добавляем обработчики для кнопок уменьшения количества
            decreaseBtns.forEach((btn) => {
                btn.addEventListener("click", function(e) {
                    // Предотвращаем стандартное поведение кнопки
                    e.preventDefault()

                    // Находим форму и поле ввода количества
                    const form = this.closest("form")
                    const input = form.querySelector(".quantity-input")
                    let value = Number.parseInt(input.value)

                    // Уменьшаем значение, если оно больше 1
                    if (value > 1) {
                        value--
                        input.value = value

                        // Отправляем форму
                        form.submit()
                    }
                })
            })

            // Добавляем обработчики для кнопок увеличения количества
            increaseBtns.forEach((btn) => {
                btn.addEventListener("click", function(e) {
                    // Предотвращаем стандартное поведение кнопки
                    e.preventDefault()

                    // Находим форму и поле ввода количества
                    const form = this.closest("form")
                    const input = form.querySelector(".quantity-input")
                    let value = Number.parseInt(input.value)

                    // Увеличиваем значение
                    value++
                    input.value = value

                    // Отправляем форму
                    form.submit()
                })
            })
        })
    </script>
</body>

</html>