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
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="8" cy="21" r="1"></circle>
                        <circle cx="19" cy="21" r="1"></circle>
                        <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
                    </svg>
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
                    <div class="cart-item" data-item-id="{{ $item->id }}">
                        <div class="cart-item-product">
                            <div class="cart-item-image">
                                <img src="{{ asset('images/' . $item->product->image) }}" alt="{{ $item->product->name_product }}">
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
                                    <button type="submit" name="action" value="decrease" class="quantity-btn quantity-decrease">−</button>
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="quantity-input" readonly>
                                    <button type="submit" name="action" value="increase" class="quantity-btn quantity-increase">+</button>
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
                                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name_product }}">
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

    <!-- Индикатор загрузки -->
    <div class="loading-indicator" id="loading-indicator">
        <div class="spinner"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Получаем все элементы, с которыми будем работать
            const quantityInputs = document.querySelectorAll('.quantity-input');
            const decreaseBtns = document.querySelectorAll('.quantity-decrease');
            const increaseBtns = document.querySelectorAll('.quantity-increase');
            const loadingIndicator = document.getElementById('loading-indicator');
            
            // Таймеры для отложенной отправки формы
            let updateTimers = {};
            
            // Функция для форматирования цены
            function formatPrice(price) {
                return new Intl.NumberFormat('ru-RU').format(price) + ' руб.';
            }
            
            // Функция для обновления цен на странице
            function updatePrices() {
                let totalQuantity = 0;
                let totalPrice = 0;
                
                // Проходим по всем товарам в корзине
                quantityInputs.forEach(input => {
                    const itemId = input.getAttribute('data-item-id');
                    const quantity = parseInt(input.value);
                    const cartItem = input.closest('.cart-item');
                    const priceElement = cartItem.querySelector('.cart-item-price');
                    const totalElement = cartItem.querySelector('.cart-item-total');
                    
                    // Получаем цену товара из атрибута data-price
                    const price = parseFloat(priceElement.textContent.replace(/\s/g, '').replace('руб.', ''));
                    
                    // Рассчитываем стоимость товара
                    const itemTotal = price * quantity;
                    
                    // Обновляем отображение стоимости товара
                    totalElement.textContent = formatPrice(itemTotal);
                    
                    // Добавляем к общей сумме и количеству
                    totalPrice += itemTotal;
                    totalQuantity += quantity;
                });
                
                // Обновляем отображение общей суммы и количества
                document.getElementById('cart-items-count').textContent = totalQuantity;
                document.getElementById('cart-subtotal').textContent = formatPrice(totalPrice);
                document.getElementById('cart-total').textContent = formatPrice(totalPrice);
            }
            
            // Функция для отправки формы с задержкой
            function submitFormWithDelay(form, delay = 500) {
                // Показываем индикатор загрузки
                loadingIndicator.classList.add('active');
                
                // Отправляем форму
                const formData = new FormData(form);
                
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    // Скрываем индикатор загрузки
                    loadingIndicator.classList.remove('active');
                    updatePrices();
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                    // Скрываем индикатор загрузки
                    loadingIndicator.classList.remove('active');
                });
            }
            
            // Обработчики для кнопок уменьшения количества
            decreaseBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const form = this.closest('form');
                    const input = form.querySelector('.quantity-input');
                    let value = parseInt(input.value);
                    
                    if (value > 1) {
                        value--;
                        input.value = value;
                        submitFormWithDelay(form);
                    }
                });
            });
            
            // Обработчики для кнопок увеличения количества
            increaseBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const form = this.closest('form');
                    const input = form.querySelector('.quantity-input');
                    let value = parseInt(input.value);
                    
                    value++;
                    input.value = value;
                    submitFormWithDelay(form);
                });
            });
        });
    </script>
</body>
</html>
