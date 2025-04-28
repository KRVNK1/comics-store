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
    <h1 class="text-2xl font-bold mb-6">Избранное</h1>

    @if($favourites->isEmpty())
        <div class="bg-white rounded-lg shadow-sm p-6 text-center">
            <p class="text-gray-500">У вас пока нет избранных товаров</p>
            <a href="/" class="mt-4 inline-block px-4 py-2 bg-red-900 text-white rounded-md hover:bg-red-800">
                Перейти к покупкам
            </a>
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach ($favourites as $favourite)
                <div class="border p-3 rounded-lg hover:shadow-md transition-shadow">
                    <a href="{{ route('products.show', $favourite->product) }}">
                        <div class="bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center mb-2" style="height: 150px;">
                            <img src="{{ asset('storage/' . $favourite->product->image) }}" 
                                 alt="{{ $favourite->product->name_product }}" 
                                 class="object-contain h-full w-full">
                        </div>
                        <h3 class="text-sm font-medium text-gray-900 mb-1">{{ $favourite->product->name_product }}</h3>
                        <p class="text-red-900 font-semibold">{{ number_format($favourite->product->price, 0, ',', ' ') }} руб.</p>
                    </a>
                    <form action="{{ route('favourites.toggle', $favourite->product) }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="text-sm text-gray-500 hover:text-red-900">
                            Удалить из избранного
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>
</body>
</html>