<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация - COMICWERS</title>
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

            <h1 class="auth-title">Добро пожаловать обратно, читатель!</h1>
            <p class="auth-subtitle">Войдите в систему, чтобы стать супергероем!</p>

            @if ($errors->any())
            <div class="auth-errors">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="auth-form">
                @csrf

                <div class="form-group">
                    <input type="text" id="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="Адрес электронной почты или имя пользователя" class="auth-input">
                </div>

                <div class="form-group">
                    <input type="password" id="password" name="password" required
                        placeholder="Пароль" class="auth-input">
                </div>

                <div class="form-group">
                    <button type="submit" class="auth-button">Авторизоваться</button>
                </div>
            </form>

            <div class="auth-links">
                <p>У вас нет учетной записи? <a href="{{ route('register') }}">Регистрация</a></p>
            </div>
        </div>
    </div>
</body>

</html>