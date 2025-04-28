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
    <h2 class="text-2xl font-semibold mb-6 text-center">Регистрация</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Имя</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('name')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('email')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Пароль</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('password')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password-confirm" class="block text-sm font-medium text-gray-700">Подтвердите пароль</label>
            <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password"
                class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700">Адрес</label>
            <input id="address" type="text" name="address" value="{{ old('address') }}" required
                class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('address')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex items-center justify-end mt-6">
            <button type="submit" class="bg-red-900 text-white px-4 py-2 rounded-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-900">
                Зарегистрироваться
            </button>
        </div>
    </form>

    <div class="mt-4 text-center">
        <p class="text-sm text-gray-600">Уже есть аккаунт? <a href="{{ route('login') }}" class="text-red-900 hover:underline">Войти</a></p>
    </div>
</div>

</body>
</html>