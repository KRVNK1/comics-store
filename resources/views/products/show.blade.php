
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
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
     <!-- Хлебные крошки -->
<div class="px-6 py-4 border-b">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="/" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-red-900">
                    Главная
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('categories.show', $product->category) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-red-900 md:ml-2">
                        {{ $product->category->name_category }}
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $product->name_product }}</span>
                </div>
            </li>
        </ol>
    </nav>
</div>

        <!-- Основная информация о товаре -->
        <div class="md:flex">
            <!-- Изображение товара -->
            <div class="md:w-1/2 p-6">
                <div class="bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center" style="height: 400px;">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400' }}" 
                         alt="{{ $product->name_product }}" 
                         class="object-contain h-full w-full">
                </div>
            </div>

            <!-- Информация о товаре -->
            <div class="md:w-1/2 p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $product->name_product }}</h1>
                
                <div class="flex items-center mb-4">
                    <div class="text-3xl font-bold text-red-900 mr-4">{{ number_format($product->price, 0, ',', ' ') }} руб.</div>
                    @if($product->price < 5000)
                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Бесплатная доставка</span>
                    @endif
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Краткое описание</h3>
                    <p class="text-gray-700">{{ $product->short_description }}</p>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Характеристики</h3>
                    <ul class="list-disc pl-5 text-gray-700">
                        <!-- Здесь можно добавить дополнительные характеристики -->
                        <li>Категория: {{ $product->category->name_category }}</li>
                        <li>Артикул: {{ $product->id }}</li>
                    </ul>
                </div>

                <div class="flex items-center mb-6">
    <form action="{{ route('cart.add', $product) }}" method="POST" class="mr-4">
        @csrf
        <button type="submit" class="bg-red-900 hover:bg-red-800 text-white font-bold py-3 px-6 rounded-lg">
            Добавить в корзину
        </button>
    </form>
    
    <form action="{{ route('favourites.toggle', $product) }}" method="POST">
        @csrf
        <button type="submit" class="border border-gray-300 hover:bg-gray-100 text-gray-800 font-bold py-3 px-6 rounded-lg">
            @if(auth()->user()->favourites()->where('product_id', $product->id)->exists())
                Уже в избранном
            @else
            В избранное
            @endif
        </button>
    </form>
</div>
            </div>
        </div>

        <!-- Полное описание товара -->
        <div class="p-6 border-t">
            <h3 class="text-lg font-semibold mb-4">Описание товара</h3>
            <div class="prose max-w-none text-gray-700">
                {!! nl2br(e($product->description)) !!}
            </div>
        </div>
    </div>

    <!-- Похожие товары -->
    @if($relatedProducts->count() > 0)
    <div class="mt-12">
        <h2 class="text-xl font-bold mb-6">Похожие товары</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach ($relatedProducts as $relatedProduct)
                <a href="{{ route('products.show', $relatedProduct) }}" class="border p-4 rounded-lg hover:shadow-md transition-shadow">
                    <div class="bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center mb-2" style="height: 150px;">
                        <img src="{{ $relatedProduct->image ? asset('storage/' . $relatedProduct->image) : 'https://via.placeholder.com/150' }}" 
                             alt="{{ $relatedProduct->name_product }}" 
                             class="object-contain h-full w-full">
                    </div>
                    <h3 class="text-sm font-medium text-gray-900 mb-1">{{ $relatedProduct->name_product }}</h3>
                    <p class="text-red-900 font-semibold">{{ number_format($relatedProduct->price, 0, ',', ' ') }} руб.</p>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    @if(auth()->user()->isAdmin())
<div class="mt-8 pt-6 border-t">
    <div class="flex space-x-4">
        <a href="{{ route('products.edit', $product) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
            Редактировать товар
        </a>
        
        <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Вы уверены, что хотите удалить этот товар?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-900 text-white rounded-md hover:bg-red-800">
                Удалить товар
            </button>
        </form>
    </div>
</div>
@endif
</div>
</body>
</html>