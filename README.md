

## Установка проекта

1)Установить composer
composer install

2)Создать файл .env и исправить его
cp .env.example .env
php artisan key:generate

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=НазваниеБД
DB_USERNAME=root
DB_PASSWORD=(пароль, если есть)

3)Сделать миграции
php artisan migrate:fresh --seed

## Запуск проекта

1)php artisan serve
