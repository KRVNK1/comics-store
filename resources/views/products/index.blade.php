<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог товаров - COMICWERS</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ledger&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Шапка сайта -->
    @include('components.header')

    <!-- Основной контент -->
    <main class="container">
        <div class="catalog-header">
            <h1 class="page-title">Каталог товаров</h1>

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

            <!-- Кнопка добавления товара для администратора -->
            @if($isAdmin)
            <div class="admin-actions">
                <a href="{{ route('products.create') }}" class="btn-admin">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Добавить товар
                </a>
            </div>
            @endif
        </div>

        <div class="catalog-container">
            <!-- Фильтры -->
            <aside class="sidebar">
                <nav class="category-menu">
                    <ul>
                        <li>
                            <a href="{{ route('products.index') }}" class="active">
                                <i class="icon home-icon">
                                    <img src="{{ asset('images/icons/home.png') }}" alt="">
                                </i>Каталог
                            </a>
                        </li>
                        @foreach($categories as $category)
                        <li>
                            <a href="{{ route('categories.show', $category->id) }}">
                                <i class="icon category-icon">

                                    @if( $category -> name_category == 'Супергерои')
                                    <img src="{{ asset('images/icons/superhero.png') }}" alt="">
                                    @elseif ( $category -> name_category == 'Фэнтези')
                                    <img src="{{ asset('images/icons/fantasy.png') }}" alt="">
                                    @elseif ( $category -> name_category == 'Научная фантастика')
                                    <img src="{{ asset('images/icons/fantastic.png') }}" alt="">
                                    @elseif ( $category -> name_category == 'Хоррор')
                                    <img src="{{ asset('images/icons/horror.png') }}" alt="">
                                    @elseif ( $category -> name_category == 'Приключения')
                                    <img src="{{ asset('images/icons/adventures.png') }}" alt="">
                                    @elseif ( $category -> name_category == 'Манга')
                                    <img src="{{ asset('images/icons/manga.png') }}" alt="">
                                    @else
                                    <img src="{{ asset('images/icons/child-comics.png') }}" alt="">
                                    @endif

                                </i>{{ $category->name_category }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </nav>
            </aside>

            <!-- Список товаров -->
            <div class="catalog-products">
                @if($products->isEmpty())
                <div class="empty-products">
                    <p>Товары не найдены</p>
                </div>
                @else
                <div class="products-grid">
                    @foreach($products as $product)
                    <div class="product-card" style="width: 100%;">
                        <a href="{{ route('products.show', $product->id) }}" class="product-link">
                            <div class="product-image">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name_product }}">
                            </div>
                            <div class="product-info">
                                <h3 class="product-title">{{ $product->name_product }}</h3>
                                <p class="product-price">{{ number_format($product->price, 0, ',', ' ') }} руб.</p>
                            </div>
                        </a>

                        <!-- Кнопки управления для администратора -->
                        @if($isAdmin)
                        <div class="admin-product-actions">
                            <a href="{{ route('products.edit', $product->id) }}" class="btn-admin-edit" title="Редактировать">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Вы уверены, что хотите удалить этот товар?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-admin-delete" title="Удалить">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>

                <div class="pagination">
                    {{ $products->links() }}
                </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Подвал сайта -->
    @include('components.footer')
</body>

</html>