
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
    <h1 class="text-2xl font-bold mb-6">Редактирование товара</h1>

    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Категория</label>
                <select name="id_category" required
                    class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-red-900 focus:ring-red-900">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->id_category == $category->id ? 'selected' : '' }}>
                            {{ $category->name_category }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Название товара</label>
                <input type="text" name="name_product" required value="{{ old('name_product', $product->name_product) }}"
                    class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-red-900 focus:ring-red-900">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Цена</label>
                <input type="number" step="0.01" name="price" required value="{{ old('price', $product->price) }}"
                    class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-red-900 focus:ring-red-900">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Изображение</label>
                <input type="file" name="image"
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-900 hover:file:bg-red-100">
                @if($product->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Текущее изображение" class="h-20">
                        <p class="text-xs text-gray-500 mt-1">Текущее изображение</p>
                    </div>
                @endif
            </div>
            
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Краткое описание</label>
                <input type="text" name="short_description" required value="{{ old('short_description', $product->short_description) }}"
                    class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-red-900 focus:ring-red-900">
            </div>
            
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Полное описание</label>
                <textarea name="description" rows="5" required
                    class="mt-1 block w-full rounded-md border-2 border-gray-200 shadow-sm focus:border-red-900 focus:ring-red-900">{{ old('description', $product->description) }}</textarea>
            </div>
        </div>
        
        <div class="mt-6 flex justify-between">
            <button type="submit" class="px-4 py-2 bg-red-900 text-white rounded-md hover:bg-red-800">
                Сохранить изменения
            </button>
            
            <a href="{{ route('products.show', $product) }}" class="px-4 py-2 border border-2 border-gray-200 rounded-md hover:bg-gray-50">
                Отмена
            </a>
        </div>
    </form>
    
    @if(auth()->user()->isAdmin())
    <div class="mt-8 pt-6 border-t">
        <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Вы уверены, что хотите удалить этот товар?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-900 hover:text-red-700">
                Удалить товар
            </button>
        </form>
    </div>
    @endif
</div>
</body>
</html>