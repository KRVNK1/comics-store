<header>
    <div class="header-bottom">
        <div class="container">
            <div class="menu-button">
                <button class="category-btn">
                    <span class="menu-icon"></span>
                    ВСЕ КАТЕГОРИИ
                </button>
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
                    <a href="{{ route('profile.show') }}" class="auth-btn profile">{{ Auth::user()->name }}</a>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="auth-btn logout">Выход</button>
                    </form>
                @endguest
            </div>
        </div>
    </div>
</header>