<header>
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
                    @if(session()->has('cart') && count(session('cart')) > 0)
                    <span class="cart-count">{{ count(session('cart')) }}</span>
                    @endif
                </a>
                <a href="{{ route('profile.show') }}" class="auth-btn profile">Профиль</a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="auth-btn logout">Выход</button>
                </form>
                @endguest
            </div>
        </div>
    </div>
</header>