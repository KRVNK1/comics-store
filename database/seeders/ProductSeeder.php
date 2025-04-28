<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superheroesId = Category::where('name_category', 'Супергерои')->first()->id;
        $horrorId = Category::where('name_category', 'Хоррор')->first()->id;
        $fantasyId = Category::where('name_category', 'Фэнтези')->first()->id;
        $scifiId = Category::where('name_category', 'Научная фантастика')->first()->id;
        $adventureId = Category::where('name_category', 'Приключения')->first()->id;

        $products = [
            [
                'name_product' => 'Бесобой. Том 5. Метро',
                'price' => 1400,
                'image' => 'comics/besoboy.png',
                'id_category' => $horrorId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_product' => 'The Boys',
                'price' => 1564,
                'image' => 'comics/the_boys.png',
                'id_category' => $superheroesId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_product' => 'Marvel Team-Up Vol. 4',
                'price' => 2654,
                'image' => 'comics/marvel_team_up.png',
                'id_category' => $superheroesId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_product' => 'Avengers',
                'price' => 3260,
                'image' => 'comics/avengers.png',
                'id_category' => $superheroesId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_product' => 'Люди Икс №209',
                'price' => 1110,
                'image' => 'comics/x_men.png',
                'id_category' => $superheroesId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_product' => 'Amazing Spider-Man Vol 1 3',
                'price' => 1595,
                'image' => 'comics/spiderman.png',
                'id_category' => $superheroesId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_product' => 'Песочный человек. Том 1',
                'price' => 2100,
                'image' => 'comics/sandman.png',
                'id_category' => $fantasyId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_product' => 'Сага. Книга первая',
                'price' => 1850,
                'image' => 'comics/saga.png',
                'id_category' => $scifiId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_product' => 'Ходячие мертвецы. Том 1',
                'price' => 1450,
                'image' => 'comics/walking_dead.png',
                'id_category' => $horrorId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_product' => 'Хеллбой. Семя разрушения',
                'price' => 1680,
                'image' => 'comics/hellboy.png',
                'id_category' => $fantasyId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_product' => 'Черепашки-ниндзя. Городская легенда',
                'price' => 1320,
                'image' => 'comics/tmnt.png',
                'id_category' => $adventureId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_product' => 'Бэтмен. Год первый',
                'price' => 1750,
                'image' => 'comics/batman_year_one.png',
                'id_category' => $superheroesId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Product::insert($products);
    }
}
