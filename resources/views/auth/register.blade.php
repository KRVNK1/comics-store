<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - COMICWERS</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ledger&display=swap" rel="stylesheet">
</head>

<body class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-logo">
                <img src="{{ asset('images/comicwers-footer-logo.png') }}" alt="COMICWERS">
            </div>

            <h1 class="auth-title">Регистрируйтесь и погружайтесь в комиксы!</h1>
            <p class="auth-subtitle">Открывайте новые приключения</p>

            @if ($errors->any())
            <div class="auth-errors">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="auth-form">
                @csrf

                <div class="form-row">
                    <div class="form-group half">
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                            placeholder="Имя" class="auth-input">
                    </div>

                    <div class="form-group half">
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required
                            placeholder="Фамилия" class="auth-input">
                    </div>
                </div>

                <div class="form-group">
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        placeholder="Электронная почта" class="auth-input">
                </div>

                <div class="form-group">
                    <input type="text" id="address" name="address" value="{{ old('address') }}" required
                        placeholder="Адрес" class="auth-input">
                </div>

                <div class="form-group">
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                        placeholder="Телефон" class="auth-input">
                </div>

                <div class="form-group">
                    <input type="password" id="password" name="password" required
                        placeholder="Пароль" class="auth-input">
                </div>

                <div class="form-group">
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        placeholder="Подтвердите пароль" class="auth-input">
                </div>

                <div class="form-group">
                    <button type="submit" class="auth-button">Зарегистрироваться</button>
                </div>
            </form>

            <div class="auth-links">
                <p>У вас уже есть учетная запись? <a href="{{ route('login') }}">Авторизоваться</a></p>
            </div>
        </div>
    </div>
</body>

</html>