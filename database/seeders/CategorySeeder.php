<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $tree = [
            ['name' => 'Электроника', 'children' => [
                ['name' => 'Смартфоны'],
                ['name' => 'Ноутбуки'],
                ['name' => 'Наушники'],
                ['name' => 'Планшеты'],
            ]],
            ['name' => 'Одежда', 'children' => [
                ['name' => 'Мужская'],
                ['name' => 'Женская'],
                ['name' => 'Детская'],
            ]],
            ['name' => 'Обувь', 'children' => [
                ['name' => 'Кроссовки'],
                ['name' => 'Ботинки'],
            ]],
            ['name' => 'Дом и сад', 'children' => [
                ['name' => 'Мебель'],
                ['name' => 'Посуда'],
                ['name' => 'Декор'],
            ]],
            ['name' => 'Спорт', 'children' => [
                ['name' => 'Фитнес'],
                ['name' => 'Велоспорт'],
            ]],
            ['name' => 'Красота'],
            ['name' => 'Игрушки'],
            ['name' => 'Книги'],
        ];

        $order = 0;
        foreach ($tree as $node) {
            $parent = Category::updateOrCreate(
                ['slug' => Str::slug($node['name'])],
                [
                    'name' => $node['name'],
                    'sort_order' => $order++,
                    'is_active' => true,
                ]
            );
            foreach ($node['children'] ?? [] as $childNode) {
                Category::updateOrCreate(
                    ['slug' => Str::slug($node['name'] . '-' . $childNode['name'])],
                    [
                        'name' => $childNode['name'],
                        'parent_id' => $parent->id,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
