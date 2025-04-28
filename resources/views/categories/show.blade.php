

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Магазин часов</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<style>
    /* Стили для пагинации */
.pagination {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
}

.page-item {
    margin: 0 4px;
}

.page-link {
    display: block;
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    color: #333;
    text-decoration: none;
}

.page-item.active .page-link {
    background-color: #7f1d1d; /* Цвет как в вашем дизайне */
    border-color: #7f1d1d;
    color: white;
}

.page-item.disabled .page-link {
    color: #999;
    pointer-events: none;
    cursor: not-allowed;
}

.page-link:hover {
    background-color: #f3f4f6;
}
body {
    font-family: 'Nunito', sans-serif;
}
</style>
<body class="bg-white text-gray-800">

@include('components.header')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Хлебные крошки -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="/" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-red-900">
                    Главная
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $category->name_category }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Заголовок категории -->
    <h1 class="text-2xl font-bold text-gray-900 mb-6">{{ $category->name_category }}</h1>

    <!-- Товары категории -->
    @if($products->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach ($products as $product)
                <a href="{{ route('products.show', $product) }}" class="border p-3 rounded-lg hover:shadow-md transition-shadow">
                    <div class="bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center mb-2" style="height: 150px;">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/150' }}" 
                             alt="{{ $product->name_product }}" 
                             class="object-contain h-full w-full">
                    </div>
                    <h3 class="text-sm font-medium text-gray-900 mb-1">{{ $product->name_product }}</h3>
                    <p class="text-red-900 font-semibold">{{ number_format($product->price, 0, ',', ' ') }} руб.</p>
                </a>
            @endforeach
        </div>

        <!-- Пагинация -->
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm p-6 text-center">
            <p class="text-gray-500">В этой категории пока нет товаров.</p>
        </div>
    @endif
</div>
</body>
</html>