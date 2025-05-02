<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Магазин комиксов - Личный кабинет</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ledger&display=swap" rel="stylesheet">
</head>

<body>
    @include('components.header')

    <div class="container">
        <h1 class="profile-title">Настройки учетной записи</h1>

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="profile-tabs">
            <a href="#profile-info" class="profile-tab active" data-tab="profile-info">Информация профиля</a>
            <a href="#order-history" class="profile-tab" data-tab="order-history">История заказов</a>
        </div>

        <!-- Вкладка информации профиля -->
        <div class="profile-content" id="profile-info">
            <form action="{{ route('profile.update') }}" method="POST" class="profile-form">
                @csrf
                @method('PUT')

                <h2 class="profile-section-title">Информация Профиля</h2>

                <div class="profile-form-row">
                    <div class="profile-form-group">
                        <label for="name">Имя</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="profile-input">
                        @error('name')
                        <span class="profile-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="profile-form-group">
                        <label for="last_name">Фамилия</label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="profile-input">
                        @error('last_name')
                        <span class="profile-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="profile-form-row">
                    <div class="profile-form-group">
                        <label for="email">Email Адрес</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="profile-input">
                        @error('email')
                        <span class="profile-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="profile-form-group">
                        <label for="phone_number">Номер телефона</label>
                        <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" class="profile-input" placeholder="89003332525">
                        @error('phone_number')
                        <span class="profile-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <h2 class="profile-section-title">Поменять Пароль</h2>

                <div class="profile-form-row">
                    <div class="profile-form-group">
                        <label for="password">Новый пароль</label>
                        <input type="password" id="password" name="password" class="profile-input">
                        @error('password')
                        <span class="profile-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="profile-form-group">
                        <label for="password_confirmation">Подтвердите новый пароль</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="profile-input">
                    </div>
                </div>

                <h2 class="profile-section-title">Адрес</h2>

                <div class="profile-form-group full-width">
                    <label for="address">Адрес доставки</label>
                    <textarea id="address" name="address" class="profile-input profile-textarea" placeholder="Ваш адрес">{{ old('address', $user->address) }}</textarea>
                    @error('address')
                    <span class="profile-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="profile-form-actions">
                    <button type="submit" class="profile-submit-btn">сохранить изменения</button>
                </div>
            </form>
        </div>

        <!-- Вкладка истории заказов -->
        <div class="profile-content" id="order-history" style="display: none;">
            <h2 class="profile-section-title">История заказов</h2>
            
            @if($orders->isEmpty())
                <div class="empty-orders">
                    <p>У вас пока нет заказов</p>
                    <a href="{{ route('home') }}" class="profile-link">Перейти к покупкам</a>
                </div>
            @else
                <div class="orders-table-container">
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>Номер</th>
                                <th>Заказ</th>
                                <th>Статус</th>
                                <th>Tracking ID</th>
                                <th>дата доставки</th>
                                <th>Цена</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                @foreach($order->orderItems as $item)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td class="order-product-cell">
                                        <div class="order-product-info">
                                            <div class="order-product-image">
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name_product }}">
                                            </div>
                                            <span>{{ $item->product->name_product }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="order-status">
                                            <span class="status-icon"></span>
                                            <span class="status-text">{{ $order->status_text }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="tracking-id">
                                            {{ $order->id }}{{ str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT) }}
                                            <button class="copy-button" onclick="copyToClipboard(this)" data-clipboard-text="{{ $order->id }}{{ str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                    <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                    <td class="price-cell">{{ number_format($item->price * $item->quantity, 2, '.', '') }}</td>
                                    <td>
                                        <a href="" class="reorder-button">
                                            Re-Order
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M5 12h14"></path>
                                                <path d="m12 5 7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="pagination">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>

    @include('components.footer')

    <script>
        // Функция для переключения вкладок
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.profile-tab');
            const contents = document.querySelectorAll('.profile-content');
            
            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Удаляем активный класс со всех вкладок
                    tabs.forEach(t => t.classList.remove('active'));
                    
                    // Добавляем активный класс на текущую вкладку
                    this.classList.add('active');
                    
                    // Скрываем все содержимое вкладок
                    contents.forEach(content => {
                        content.style.display = 'none';
                    });
                    
                    // Показываем содержимое выбранной вкладки
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(tabId).style.display = 'block';
                });
            });
        });

        // Функция для копирования Tracking ID
        function copyToClipboard(button) {
            const text = button.getAttribute('data-clipboard-text');
            navigator.clipboard.writeText(text).then(() => {
                // Визуальная обратная связь
                button.classList.add('copied');
                setTimeout(() => {
                    button.classList.remove('copied');
                }, 2000);
            });
        }
    </script>
</body>

</html>
