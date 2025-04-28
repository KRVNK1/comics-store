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
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-6">Оформление заказа</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Информация о заказе -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">Ваш заказ</h2>

            <div class="divide-y divide-gray-200">
                @foreach($cartItems as $item)
                <div class="py-4 flex justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-16 w-16">
                            <img class="h-16 w-16 object-contain" src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name_product }}">
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-900">{{ $item->product->name_product }}</h3>
                            <p class="text-sm text-gray-500">Количество: {{ $item->quantity }}</p>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-gray-900">{{ number_format($item->product->price * $item->quantity, 0, ',', ' ') }} руб.</p>
                </div>
                @endforeach
            </div>

            <!-- Добавлен блок для промокода -->
            <div class="border-t border-gray-200 mt-4 pt-4">
                <div class="mb-4">
                    <label for="promo_code" class="block text-sm font-medium text-gray-700">Промокод</label>
                    <div class="flex mt-1">
                        <input type="text" id="promo_code" name="promo_code"
                            class="block w-full rounded-l-md border-2 border-gray-200 shadow-sm focus:border-red-900 focus:ring-red-900">
                        <button type="button" onclick="applyPromoCode()"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-r-md text-white bg-red-900 hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-900">
                            Применить
                        </button>
                    </div>
                    <p id="promo_message" class="mt-1 text-sm text-gray-600"></p>
                </div>

                <div class="flex justify-between text-base font-medium text-gray-900">
                    <p>Итого</p>
                    <p id="total_price">{{ number_format($total, 0, ',', ' ') }} руб.</p>
                </div>
                <div id="discount_container" class="hidden flex justify-between text-base font-medium text-green-600">
                    <p>Скидка</p>
                    <p id="discount_amount"></p>
                </div>
                <div id="final_price_container" class="hidden border-t border-gray-200 mt-2 pt-2 flex justify-between text-lg font-bold text-gray-900">
                    <p>К оплате</p>
                    <p id="final_price"></p>
                </div>
            </div>
        </div>

        <!-- Форма оформления -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">Данные для доставки</h2>

            <form method="POST" action="{{ route('orders.store') }}">
                @csrf
                <!-- Скрытое поле для передачи примененного промокода -->
                <input type="hidden" id="applied_promo" name="applied_promo" value="">

                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Телефон</label>
                    <input type="text" id="phone" name="phone" required value="{{ old('phone', $user->phone ?? '') }}"
                        class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-red-900 focus:ring-red-900">
                </div>

                <div class="mb-4">
                    <label for="shipping_address" class="block text-sm font-medium text-gray-700">Адрес доставки</label>
                    <input type="text" id="shipping_address" name="shipping_address" required value="{{ old('shipping_address', $user->address ?? '') }}"
                        class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-red-900 focus:ring-red-900">
                </div>

                <div class="mb-4">
                    <label for="notes" class="block text-sm font-medium text-gray-700">Примечания к заказу</label>
                    <textarea id="notes" name="notes" rows="3"
                        class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-red-900 focus:ring-red-900">{{ old('notes') }}</textarea>
                </div>

                <button type="submit" class="w-full bg-red-900 text-white py-2 px-4 rounded-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-900">
                    Подтвердить заказ
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    async function applyPromoCode() {
        const promoCode = document.getElementById('promo_code').value;
        const promoMessage = document.getElementById('promo_message');
        const totalPriceElement = document.getElementById('total_price');
        const discountContainer = document.getElementById('discount_container');
        const finalPriceContainer = document.getElementById('final_price_container');
        const discountAmountElement = document.getElementById('discount_amount'); // Имя переменной изменено
        const finalPriceElement = document.getElementById('final_price');
        const appliedPromoField = document.getElementById('applied_promo');

        // Получаем исходную сумму из текста (удаляем пробелы и "руб.")
        const originalTotalText = totalPriceElement.textContent;
        const originalTotal = parseInt(originalTotalText.replace(/\s+/g, '').replace('руб.', ''));

        try {
            const response = await fetch('/check-promocode', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Добавьте CSRF-токен для защиты от CSRF-атак
                },
                body: JSON.stringify({ promocode: promoCode })
            });

            if (!response.ok) {
                // Обрабатываем ошибки, если сервер вернул ошибку (например, 404)
                const errorData = await response.json();
                throw new Error(errorData.message || 'Ошибка при проверке промокода');
            }

            const data = await response.json();

            if (data.valid) {
                // Промокод действителен
                const discount = data.discount;
                const discountedTotal = originalTotal - discount;

                promoMessage.textContent = `Промокод применен! Скидка ${discount.toLocaleString('ru-RU')} руб.`;
                promoMessage.className = 'mt-1 text-sm text-green-600';

                // Показываем скидку и итоговую цену
                discountContainer.classList.remove('hidden');
                finalPriceContainer.classList.remove('hidden');

                // Рассчитываем и отображаем итоговую цену
                discountAmountElement.textContent = `- ${discount.toLocaleString('ru-RU')} руб.`; // Используем правильную переменную
                finalPriceElement.textContent = discountedTotal.toLocaleString('ru-RU') + ' руб.';

                // Заполняем скрытое поле для отправки на сервер
                appliedPromoField.value = promoCode; // Передаем фактический промокод
            } else {
                // Промокод недействителен
                promoMessage.textContent = data.message || 'Неверный промокод';
                promoMessage.className = 'mt-1 text-sm text-red-600';

                // Скрываем блоки скидки и итоговой цены
                discountContainer.classList.add('hidden');
                finalPriceContainer.classList.add('hidden');

                // Очищаем скрытое поле
                appliedPromoField.value = '';
            }
        } catch (error) {
            console.error('Ошибка запроса:', error);
            promoMessage.textContent = 'Ошибка при проверке промокода';
            promoMessage.className = 'mt-1 text-sm text-red-600';

            // Скрываем блоки скидки и итоговой цены
            discountContainer.classList.add('hidden');
            finalPriceContainer.classList.add('hidden');

            // Очищаем скрытое поле
            appliedPromoField.value = '';
        }
    }
</script>

</body>
</html>
