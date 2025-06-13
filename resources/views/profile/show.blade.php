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

        @if (session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
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
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name ?? '') }}" class="profile-input">
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
                        <label for="phone">Номер телефона</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="profile-input" placeholder="89003332525">
                        @error('phone')
                        <span class="profile-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

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
                            <th>Дата доставки</th>
                            <th>Цена</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        @php
                        $firstItem = $order->orderItems->first();
                        $itemsCount = $order->orderItems->count();
                        @endphp
                        @if($firstItem && $firstItem->product)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td class="order-product-cell">
                                <div class="order-product-info">
                                    <div class="order-product-image">   
                                        <img src="{{ $firstItem->product->image_url }}" alt="{{ $firstItem->product->name_product }}">
                                    </div>
                                    <div class="order-product-details">
                                        <span class="product-name">{{ $firstItem->product->name_product }}</span>
                                        @if($itemsCount > 1)
                                        <span class="more-items">+ еще {{ $itemsCount - 1 }} товар(ов)</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="order-status">
                                    <span class="status-badge status-{{ $order->status }}">
                                        @if($order->status == 'processing')
                                        В процессе
                                        @elseif($order->status == 'completed')
                                        Завершено
                                        @elseif($order->status == 'canceled')
                                        Отменено
                                        @endif
                                    </span>
                                </div>
                            </td>
                            <td>{{ $order->created_at->format('d.m.Y') }}</td>
                            <td class="price-cell">{{ number_format($order->total_amount, 0, ',', ' ') }} руб.</td>
                            <td>
                                <a href="{{ route('orders.show', $order->id) }}" class="view-details-btn">
                                    <span>
                                        <img src="{{ asset('images/svg/Eye.svg') }}" alt="">
                                    </span>
                                    Детали
                                </a>
                            </td>
                        </tr>
                        @endif
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
    </script>
</body>

</html>