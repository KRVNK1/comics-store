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
                <img src="{{ $product->image_url }}" alt="{{ $product->name_product }}">
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

        <!-- Кнопки управления для администратора -->
        @if($isAdmin)
        <div class="admin-actions">
            <a href="{{ route('products.edit', $product->id) }}" class="btn-admin">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
                Редактировать
            </a>

            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Вы уверены, что хотите удалить этот товар?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-admin-delete">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                    Удалить
                </button>
            </form>
        </div>
        @endif

        <!-- Рекомендуемые товары -->
        <div class="section">
            <h2 class="section-title">РЕКОМЕНДУЕМ</h2>
            <div class="product-grid">
                @foreach($relatedProducts as $recProduct)
                <div class="product-card">
                    <a href="{{ route('products.show', $recProduct->id) }}">
                        <div class="product-image">
                            <img src="{{ $recProduct->image_url }}" alt="{{ $recProduct->name_product }}">
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