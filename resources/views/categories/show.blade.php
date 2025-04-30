<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->name_category }} - COMICWERS</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Шапка сайта -->
    @include('components.header')

    <!-- Основной контент -->
    <main class="container">
        <!-- Боковое меню и контент -->
        <div class="main-content">
            <!-- Боковое меню -->
            <aside class="sidebar">
                <nav class="category-menu">
                    <ul>
                        <li><a href="{{ route('home') }}"><i class="icon home-icon">
                      <img src="{{ asset('images/icons/home.png') }}" alt="">

                        </i>Главная</a></li>
                        @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('categories.show', $cat->id) }}"
                                class="{{ $cat->id == $category->id ? 'active' : '' }}">
                                <i class="icon category-icon">
                                    @if( $cat -> name_category == 'Супергерои')
                                    <img src="{{ asset('images/icons/superhero.png') }}" alt="">
                                    @elseif ( $cat -> name_category == 'Фэнтези')
                                    <img src="{{ asset('images/icons/fantasy.png') }}" alt="">
                                    @elseif ( $cat -> name_category == 'Научная фантастика')
                                    <img src="{{ asset('images/icons/fantastic.png') }}" alt="">
                                    @elseif ( $cat -> name_category == 'Хоррор')
                                    <img src="{{ asset('images/icons/horror.png') }}" alt="">
                                    @elseif ( $cat -> name_category == 'Приключения')
                                    <img src="{{ asset('images/icons/adventures.png') }}" alt="">
                                    @elseif ( $cat -> name_category == 'Манга')
                                    <img src="{{ asset('images/icons/manga.png') }}" alt="">
                                    @else
                                    <img src="{{ asset('images/icons/child-comics.png') }}" alt="">

                                    @endif
                                </i>{{ $cat->name_category }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </nav>
            </aside>

            <!-- Основной контент -->
            <section class="content">
                <h1 class="category-title">{{ $category->name_category }}</h1>

                @if($products->isEmpty())
                <div class="empty-category">
                    <p>В данной категории пока нет товаров</p>
                </div>
                @else
                <div class="product-grid">
                    @foreach($products as $product)
                    <div class="product-card">
                        <a href="{{ route('products.show', $product->id) }}">
                            <div class="product-image">
                                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name_product }}">
                            </div>
                            <div class="product-info">
                                <h3 class="product-title">{{ $product->name_product }}</h3>
                                <p class="product-price">{{ number_format($product->price, 0, ',', '.') }}руб.</p>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

                <!-- Пагинация -->
                <div class="pagination">
                    {{ $products->links() }}
                </div>
                @endif
            </section>
        </div>
    </main>

    <!-- Подвал сайта -->
    @include('components.footer')
</body>

</html>