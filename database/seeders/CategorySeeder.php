<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name_category' => 'Супергерои',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_category' => 'Фэнтези',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_category' => 'Научная фантастика',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_category' => 'Хоррор',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_category' => 'Приключения',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_category' => 'Манга',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_category' => 'Детские комиксы',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Category::insert($categories);
    }
}
