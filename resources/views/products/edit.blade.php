<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование товара - COMICWERS</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product-form.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ledger&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Шапка сайта -->
    @include('components.header')

    <!-- Основной контент -->
    <main class="container">
        <h1 class="page-title">Редактирование товара</h1>

        <div class="form-container">
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="product-form">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name_product">Название товара</label>
                    <input type="text" id="name_product" name="name_product" value="{{ old('name_product', $product->name_product) }}" class="form-control" required>
                    @error('name_product')
                    <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="id_category">Категория</label>
                    <select id="id_category" name="id_category" class="form-control" required>
                        <option value="">Выберите категорию</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('id_category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name_category }}
                        </option>
                        @endforeach
                    </select>
                    @error('id_category')
                    <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price">Цена (руб.)</label>
                    <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" class="form-control" required>
                    @error('price')
                    <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>  

                <div class="form-group">
                    <label>Текущее изображение</label>
                    <div class="current-image">
                        <img src="{{ asset('images/comics/' . $product->image) }}" alt="{{ $product->name_product }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="image">Новое изображение (оставьте пустым, чтобы не менять)</label>
                    <div class="file-input-wrapper">
                        <input type="file" id="image" name="image" class="file-input" accept="image/*">
                        <label for="image" class="file-input-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                            <span>Выберите файл</span>
                        </label>
                        <span class="file-name">Файл не выбран</span>
                    </div>
                    @error('image')
                    <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">Сохранить изменения</button>
                    <a href="{{ route('products.show', $product->id) }}" class="btn-secondary">Отмена</a>
                </div>
            </form>
        </div>
    </main>

    <!-- Подвал сайта -->
    @include('components.footer')

    <script>
        // Скрипт для отображения имени выбранного файла
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('image');
            const fileName = document.querySelector('.file-name');

            fileInput.addEventListener('change', function() {
                if (fileInput.files.length > 0) {
                    fileName.textContent = fileInput.files[0].name;
                } else {
                    fileName.textContent = 'Файл не выбран';
                }
            });
        });
    </script>
</body>

</html>