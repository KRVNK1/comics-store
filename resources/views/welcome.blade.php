<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>COMICWERS - Магазин комиксов</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Ledger&display=swap" rel="stylesheet">
</head>

<body>
  <!-- Шапка сайта -->
  <header>
    <div class="header-top">
      <img src="{{ asset('images/comicwers-logo.png') }}" alt="COMICWERS" class="logo">
    </div>
    <div class="header-bottom">
      <div class="container">
        <div class="menu-button">
          <a href="{{ route('home') }}" class="logo-btn">
            <img src="{{ asset('images/comicwers-footer-logo.png') }}" alt="">
          </a>
        </div>
        <div class="auth-buttons">
          @guest
          <a href="{{ route('login') }}" class="auth-btn login">Вход</a>
          <a href="{{ route('register') }}" class="auth-btn register">Регистрация</a>
          @else
          <a href="{{ route('cart.index') }}" class="auth-btn cart">
            Корзина
            @auth
            @if(Auth::user()->cartItems()->sum('quantity') > 0)
            <span class="cart-count">{{ Auth::user()->cartItems()->sum('quantity') }}</span>
            @endif
            @endauth
          </a>

          <a href="{{ route('profile.show') }}" class="auth-btn profile">Профиль</a>
          <form action="{{ route('logout') }}" method="POST" class=" logout">
            @csrf
            <button type="submit" class="auth-btn">Выход</button>
          </form>

          @endguest
        </div>
      </div>
    </div>
  </header>

  <!-- Основной контент -->
  <main class="container">
    <!-- Боковое меню и контент -->
    <div class="main-content">

      <!-- Основной контент -->
      <section class="content">
        <!-- Главный баннер -->
        <div class="main-banner">
          <!-- Боковое меню -->
          <aside class="sidebar">
            <nav class="category-menu">
              <ul>
                <li>
                  <a href="{{ route('products.index') }}">
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
          <img src="{{ asset('images/main-banner.png') }}" alt="Новинки">
        </div>

        <!-- Промо-баннеры -->
        <div class="promo-banners">
          <div class="promo-banner">
            <img src="{{ asset('images/promo1.png') }}" alt="Футари">
          </div>
          <div class="promo-banner">
            <img src="{{ asset('images/promo2.png') }}" alt="Волков">
          </div>
          <div class="promo-banner">
            <img src="{{ asset('images/promo3.png') }}" alt="Холят">
          </div>
        </div>

        <!-- Популярные товары -->
        <div class="section">
          <h2 class="section-title">ПОПУЛЯРНЫЕ ТОВАРЫ</h2>
          <div class="product-grid">
            @foreach($popularProducts as $product)
            <div class="product-card">
              <a href="{{ route('products.show', $product->id) }}">
                <div class="product-image">
                  <img src="{{ $product->image_url }}" alt="{{ $product->name_product }}">
                </div>
                <div class="product-info">
                  <p class="product-title">{{ $product->name_product }}</p>
                  <p class="product-price">{{ number_format($product->price, 0, ',', '.') }}руб.</p>
                </div>
              </a>
            </div>
            @endforeach
          </div>
        </div>

        <!-- Средний баннер -->
        <div class="middle-banner">
          <img src="{{ asset('images/middle-banner.png') }}" alt="Герои комиксов">
        </div>

        <!-- Новые поступления -->
        <div class="section">
          <h2 class="section-title">НОВЫЕ ПОСТУПЛЕНИЯ</h2>
          <div class="product-grid">
            @foreach($newProducts as $product)
            <div class="product-card">
              <a href="{{ route('products.show', $product->id) }}">
                <div class="product-image">
                  <img src="{{ $product->image_url }}" alt="{{ $product->name_product }}">
                </div>
                <div class="product-info">
                  <p class="product-title">{{ $product->name_product }}</p>
                  <p class="product-price">{{ number_format($product->price, 0, ',', '.') }}руб.</p>
                </div>
              </a>
            </div>
            @endforeach
          </div>
        </div>
      </section>
    </div>
  </main>

  <!-- Подвал сайта -->
  <footer>
    <div class="container">
      <div class="footer-content">
        <div class="footer-logo">
          <a href="#">
            <img src="{{ asset('images/comicwers-footer-logo.png') }}" alt="COMICWERS">
          </a>
          <p class="footer-slogan">«Погружение в мир комиксов: страницы, которые создают вселенные, — всё доступно в один клик!»</p>
        </div>
        <div class="footer-column">
          <h3>О КОМПАНИИ</h3>
          <ul>
            <li><a href="#">О нас</a></li>
            <li><a href="#">Документация</a></li>
            <li><a href="#">Спонсоры</a></li>
          </ul>
        </div>
        <div class="footer-column">
          <h3>КОНТАКТЫ</h3>
          <p>Иркутск,<br>ул. Ленина, 5а</p>
          <p>8(964)-279-55-55</p>
          <p>denis837@gmail.com</p>
        </div>
      </div>
      <div class="footer-bottom">
        <p>(C)2025 - Наш лучший магазин</p>
      </div>
    </div>
  </footer>
</body>

</html>