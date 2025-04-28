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
<div class="max-w-4xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold mb-6 text-red-900">Личный кабинет</h1>
    
    <!-- Общий раздел заказов -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">
            @auth
                @if(auth()->user()->isAdmin())
                    Заказы
                @else
                    Мои заказы
                @endif
            @endauth
        </h2>
        <a href="{{ route('orders.index') }}" class="inline-flex items-center text-red-900 hover:text-red-700">
            @auth
                @if(auth()->user()->isAdmin())
                    Управление заказами
                @else
                    История заказов
                @endif
            @endauth
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Сообщения об успехе -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Информация о пользователе -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Мой профиль</h2>
            
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Имя</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                            class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-red-900 focus:ring-red-900">
                        @error('name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                            class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-red-900 focus:ring-red-900">
                        @error('email')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700">Адрес</label>
                        <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}"
                            class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-red-900 focus:ring-red-900">
                        @error('address')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" 
                        class="px-4 py-2 bg-red-900 text-white rounded-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-900">
                        Сохранить изменения
                    </button>
                </div>
            </form>
        </div>

        <!-- Смена пароля -->
        <div>
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Смена пароля</h2>
            
            <form method="POST" action="{{ route('profile.change-password') }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Текущий пароль</label>
                        <input type="password" id="current_password" name="current_password" 
                            class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-red-900 focus:ring-red-900">
                        @error('current_password')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700">Новый пароль</label>
                        <input type="password" id="new_password" name="new_password" 
                            class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-red-900 focus:ring-red-900">
                        @error('new_password')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Подтвердите новый пароль</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" 
                            class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-red-900 focus:ring-red-900">
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" 
                        class="px-4 py-2 bg-red-900 text-white rounded-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-900">
                        Изменить пароль
                    </button>
                </div>
            </form>
        </div>
    </div>
 
    @if(auth()->user()->isAdmin())
    <div class="mt-12">
        <h2 class="text-2xl font-bold mb-6 text-red-900">Администрирование</h2>
        
        <!-- Форма добавления категории -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Добавить категорию</h3>
            <form method="POST" action="{{ route('profile.add-category') }}">
                @csrf
                <div class="flex">
                    <input type="text" name="name_category" required 
                        class="flex-grow rounded-l-md border-2 border-gray-200 shadow-sm focus:border-red-900 focus:ring-red-900"
                        placeholder="Название категории">
                    <button type="submit" class="bg-red-900 text-white px-4 py-2 rounded-r-md hover:bg-red-800">
                        Добавить
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Форма добавления товара -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Добавить товар</h3>
            <form method="POST" action="{{ route('profile.add-product') }}" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Категория</label>
                        <select name="id_category" required
                            class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-red-900 focus:ring-red-900">
                            @foreach(App\Models\Category::all() as $category)
                                <option value="{{ $category->id }}">{{ $category->name_category }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Название товара</label>
                        <input type="text" name="name_product" required
                            class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-red-900 focus:ring-red-900">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Цена</label>
                        <input type="number" step="0.01" name="price" required
                            class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-red-900 focus:ring-red-900">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Изображение</label>
                        <input type="file" name="image" required accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-900 hover:file:bg-red-100">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Краткое описание</label>
                        <input type="text" name="short_description" required
                            class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-red-900 focus:ring-red-900">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Полное описание</label>
                        <textarea name="description" rows="3" required
                            class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-red-900 focus:ring-red-900"></textarea>
                    </div>
                </div>
                
                <div class="mt-6">
                    <button type="submit" class="bg-red-900 text-white px-4 py-2 rounded-md hover:bg-red-800">
                        Добавить товар
                    </button>
                </div>
            </form>
        </div>
        @if(auth()->user()->status_user == 1)
<div class="mt-12">
    <h2 class="text-2xl font-bold mb-6 text-red-900">Управление промокодами</h2>
    
    <!-- Форма создания промокода -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-800">Создать промокод</h3>
        <form method="POST" action="{{ route('promocodes.store') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Код промокода</label>
                    <input type="text" name="code" required 
                        class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-red-900 focus:ring-red-900"
                        placeholder="Например: SUMMER20">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Размер скидки (руб.)</label>
                    <input type="number" name="price" min="1" required 
                        class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-red-900 focus:ring-red-900"
                        placeholder="Например: 1000">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-red-900 text-white px-4 py-2 rounded-md hover:bg-red-800">
                        Создать
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Список существующих промокодов -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-800">Список промокодов</h3>
        
        @if($promocodes->isEmpty())
            <p class="text-gray-500">Нет созданных промокодов</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Код</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Скидка</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($promocodes as $promocode)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $promocode->code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($promocode->price, 0, ',', ' ') }} руб.</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <form method="POST" action="{{ route('promocodes.destroy', $promocode->id) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-900 hover:text-red-700" onclick="return confirm('Удалить этот промокод?')">
                                        Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endif
    </div>
    @endif
</div>
</body>
</html>