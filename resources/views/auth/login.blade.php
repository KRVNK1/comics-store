
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Магазин часов</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<style>
    body {
    font-family: 'Nunito', sans-serif;
}
</style>
<body class="bg-white text-gray-800">

@include('components.header')


<div class="max-w-md mx-auto my-10 bg-white p-6 rounded-lg shadow-sm">
    <h2 class="text-2xl font-semibold mb-6 text-center">Вход</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('email')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Пароль</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('password')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4 flex items-center">
            <input id="remember" type="checkbox" name="remember" class="h-4 w-4 text-red-900 focus:ring-red-900 border-gray-300 rounded">
            <label for="remember" class="ml-2 block text-sm text-gray-700">Запомнить меня</label>
        </div>

        <div class="flex items-center justify-between mt-6">
            <button type="submit" class="bg-red-900 text-white px-4 py-2 rounded-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-900">
                Войти
            </button>

            @if (Route::has('password.request'))
                <a class="text-sm text-red-900 hover:underline" href="{{ route('password.request') }}">
                    Забыли пароль?
                </a>
            @endif
        </div>
    </form>

    <div class="mt-4 text-center">
        <p class="text-sm text-gray-600">Нет аккаунта? <a href="{{ route('register') }}" class="text-red-900 hover:underline">Зарегистрироваться</a></p>
    </div>
</div>
</body>
</html>