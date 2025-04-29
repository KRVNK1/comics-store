<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name_product }} - COMICWERS</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ledger&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Шапка сайта -->
    @include('components.header')

    <!-- Основной контент -->
    <main class="container">
        <!--  -->
        <div class="breadcrumbs">
            <a href="{{ route('home') }}">Главная /</a>
            <a href="{{ route('categories.show', $product->category->id) }}">{{ $product->category->name_category }}</a> /
            <span>{{ $product->name_product }}</span>
        </div>

        <!-- Карточка товара -->
        <div class="product-detail">
            <div class="product-image-container">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name_product }}" class="product-detail-image">
            </div>
            <div class="product-info-container">
                <h1 class="product-detail-title">{{ $product->name_product }}</h1>
                <div class="product-detail-price">
                    <span class="price-label">Цена:</span>
                    <span class="price-value">{{ number_format($product->price, 0, ',', '.') }} руб.</span>
                </div>

                <form action="{{ route('cart.add', $product) }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_product" value="{{ $product->id }}">
                    <button type="submit" class="add-to-cart-btn">Добавить в корзину</button>
                </form>

                <div class="product-tabs">
                    <div class="tab-header">
                        <div class="tab-item active" data-tab="delivery">ДОСТАВКА</div>
                        <div class="tab-item" data-tab="payment">ОПЛАТА</div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="delivery">
                            <p>Выбрать удобный способ оплаты Вы можете в корзине сайта. Читайте подробную информацию об оплате на странице «Оплата»</p>
                        </div>
                        <div class="tab-pane" id="payment">
                            <p>Информация об оплате</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Рекомендуемые товары -->
        <div class="section">
            <h2 class="section-title">РЕКОМЕНДУЕМ</h2>
            <div class="product-grid">
                @foreach($recommendedProducts as $recProduct)
                <div class="product-card">
                    <a href="{{ route('products.show', $recProduct->id) }}">
                        <div class="product-image">
                            <img src="{{ asset('storage/' . $recProduct->image) }}" alt="{{ $recProduct->name_product }}">
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">{{ $recProduct->name_product }}</h3>
                            <p class="product-price">{{ number_format($recProduct->price, 0, ',', '.') }}руб.</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </main>

    <!-- Подвал сайта -->
    @include('components.footer')

    <script>
        // Простой скрипт для работы вкладок
        document.addEventListener('DOMContentLoaded', function() {
            const tabItems = document.querySelectorAll('.tab-item');

            tabItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Удаляем активный класс у всех вкладок
                    tabItems.forEach(tab => tab.classList.remove('active'));

                    // Скрываем все панели
                    document.querySelectorAll('.tab-pane').forEach(pane => {
                        pane.classList.remove('active');
                    });

                    // Добавляем активный класс текущей вкладке
                    this.classList.add('active');

                    // Показываем соответствующую панель
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(tabId).classList.add('active');
                });
            });
        });
    </script>
</body>

</html>