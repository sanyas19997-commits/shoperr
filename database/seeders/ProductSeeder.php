<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // Смартфоны
            ['cat' => 'elektronika-smartfony', 'name' => 'Смартфон Apple iPhone 15 128GB', 'price' => 89990, 'old' => 99990, 'featured' => true, 'short' => 'Новейший iPhone с чипом A16 Bionic', 'attrs' => ['Экран' => '6.1"', 'Память' => '128 ГБ', 'Цвет' => 'Черный']],
            ['cat' => 'elektronika-smartfony', 'name' => 'Смартфон Samsung Galaxy S24 256GB', 'price' => 79990, 'old' => 89990, 'featured' => true, 'short' => 'Флагман Samsung с AI-функциями', 'attrs' => ['Экран' => '6.2"', 'Память' => '256 ГБ']],
            ['cat' => 'elektronika-smartfony', 'name' => 'Смартфон Xiaomi Redmi Note 13', 'price' => 19990, 'old' => null, 'featured' => false, 'short' => 'Доступный смартфон с отличной камерой', 'attrs' => ['Экран' => '6.67"', 'Память' => '128 ГБ']],
            // Ноутбуки
            ['cat' => 'elektronika-noutbuki', 'name' => 'Ноутбук Apple MacBook Air 13" M2', 'price' => 129990, 'old' => 139990, 'featured' => true, 'short' => 'Тонкий и мощный ноутбук на Apple Silicon', 'attrs' => ['Процессор' => 'M2', 'ОЗУ' => '8 ГБ', 'SSD' => '256 ГБ']],
            ['cat' => 'elektronika-noutbuki', 'name' => 'Ноутбук Lenovo ThinkPad X1 Carbon', 'price' => 149990, 'old' => null, 'featured' => false, 'short' => 'Бизнес-ноутбук премиум-класса', 'attrs' => ['Процессор' => 'Intel i7', 'ОЗУ' => '16 ГБ']],
            ['cat' => 'elektronika-noutbuki', 'name' => 'Ноутбук ASUS VivoBook 15', 'price' => 54990, 'old' => 59990, 'featured' => false, 'short' => 'Универсальный ноутбук для работы', 'attrs' => ['Экран' => '15.6"', 'ОЗУ' => '8 ГБ']],
            // Наушники
            ['cat' => 'elektronika-naushniki', 'name' => 'Наушники Apple AirPods Pro 2', 'price' => 22990, 'old' => 27990, 'featured' => true, 'short' => 'Беспроводные наушники с шумоподавлением', 'attrs' => ['Тип' => 'TWS']],
            ['cat' => 'elektronika-naushniki', 'name' => 'Наушники Sony WH-1000XM5', 'price' => 34990, 'old' => null, 'featured' => false, 'short' => 'Флагманские накладные наушники', 'attrs' => ['Тип' => 'Over-ear']],
            // Планшеты
            ['cat' => 'elektronika-planshety', 'name' => 'Планшет Apple iPad Air M2', 'price' => 79990, 'old' => null, 'featured' => true, 'short' => 'iPad с чипом M2 — мощь и удобство', 'attrs' => ['Экран' => '11"']],
            // Одежда мужская
            ['cat' => 'odezhda-muzhskaya', 'name' => 'Куртка мужская зимняя', 'price' => 8990, 'old' => 12990, 'featured' => false, 'short' => 'Тёплая зимняя куртка на пуху', 'attrs' => ['Материал' => 'Полиэстер']],
            ['cat' => 'odezhda-muzhskaya', 'name' => 'Футболка мужская хлопок', 'price' => 1490, 'old' => 1990, 'featured' => false, 'short' => 'Базовая хлопковая футболка', 'attrs' => ['Материал' => 'Хлопок 100%']],
            ['cat' => 'odezhda-muzhskaya', 'name' => 'Джинсы прямые классические', 'price' => 3990, 'old' => null, 'featured' => false, 'short' => 'Классические прямые джинсы', 'attrs' => []],
            // Одежда женская
            ['cat' => 'odezhda-zhenskaya', 'name' => 'Платье вечернее', 'price' => 5990, 'old' => 7990, 'featured' => true, 'short' => 'Элегантное вечернее платье', 'attrs' => ['Цвет' => 'Черный']],
            ['cat' => 'odezhda-zhenskaya', 'name' => 'Блузка шёлковая', 'price' => 4990, 'old' => null, 'featured' => false, 'short' => 'Блузка из натурального шёлка', 'attrs' => ['Материал' => 'Шёлк']],
            // Обувь
            ['cat' => 'obuv-krossovki', 'name' => 'Кроссовки Nike Air Max 90', 'price' => 12990, 'old' => 14990, 'featured' => true, 'short' => 'Легендарные кроссовки Nike', 'attrs' => ['Размер' => '42']],
            ['cat' => 'obuv-krossovki', 'name' => 'Кроссовки Adidas Ultraboost', 'price' => 15990, 'old' => null, 'featured' => false, 'short' => 'Кроссовки для бега с амортизацией', 'attrs' => []],
            ['cat' => 'obuv-botinki', 'name' => 'Ботинки мужские кожаные', 'price' => 9990, 'old' => null, 'featured' => false, 'short' => 'Классические кожаные ботинки', 'attrs' => ['Материал' => 'Кожа']],
            // Дом
            ['cat' => 'dom-i-sad-mebel', 'name' => 'Стол обеденный дубовый', 'price' => 24990, 'old' => 29990, 'featured' => false, 'short' => 'Обеденный стол из массива дуба', 'attrs' => ['Материал' => 'Дуб', 'Размер' => '160x90 см']],
            ['cat' => 'dom-i-sad-posuda', 'name' => 'Набор кастрюль нержавеющая сталь', 'price' => 7990, 'old' => null, 'featured' => false, 'short' => 'Набор кастрюль из 5 предметов', 'attrs' => []],
            ['cat' => 'dom-i-sad-dekor', 'name' => 'Ваза керамическая', 'price' => 1990, 'old' => null, 'featured' => false, 'short' => 'Декоративная керамическая ваза', 'attrs' => []],
            // Спорт
            ['cat' => 'sport-fitnes', 'name' => 'Гантели разборные 20 кг', 'price' => 5990, 'old' => 6990, 'featured' => false, 'short' => 'Набор разборных гантелей', 'attrs' => ['Вес' => '20 кг']],
            ['cat' => 'sport-velosport', 'name' => 'Велосипед горный 26"', 'price' => 34990, 'old' => null, 'featured' => true, 'short' => 'Горный велосипед для активного отдыха', 'attrs' => []],
            // Красота
            ['cat' => 'krasota', 'name' => 'Крем для лица увлажняющий', 'price' => 1490, 'old' => null, 'featured' => false, 'short' => 'Увлажняющий крем для всех типов кожи', 'attrs' => []],
            ['cat' => 'krasota', 'name' => 'Парфюмерная вода 50 мл', 'price' => 4990, 'old' => 5990, 'featured' => false, 'short' => 'Парфюмерная вода со свежим ароматом', 'attrs' => []],
            // Игрушки
            ['cat' => 'igrushki', 'name' => 'Конструктор 500 деталей', 'price' => 2990, 'old' => null, 'featured' => false, 'short' => 'Развивающий конструктор', 'attrs' => []],
            ['cat' => 'igrushki', 'name' => 'Мягкая игрушка медведь', 'price' => 1490, 'old' => null, 'featured' => false, 'short' => 'Большой плюшевый медведь', 'attrs' => []],
            // Книги
            ['cat' => 'knigi', 'name' => 'Книга «Мастер и Маргарита»', 'price' => 890, 'old' => null, 'featured' => false, 'short' => 'Классика М. Булгакова', 'attrs' => ['Автор' => 'М. Булгаков']],
            ['cat' => 'knigi', 'name' => 'Книга «Чистый код»', 'price' => 1590, 'old' => null, 'featured' => true, 'short' => 'Р. Мартин о создании качественного кода', 'attrs' => ['Автор' => 'Р. Мартин']],
        ];

        $placeholderColors = ['0d6efd', '198754', 'dc3545', '6f42c1', 'fd7e14', '20c997', '0dcaf0', 'd63384'];

        foreach ($items as $idx => $item) {
            $category = Category::where('slug', $item['cat'])->first();
            if (!$category) continue;

            $product = Product::updateOrCreate(
                ['slug' => Str::slug($item['name']) . '-' . $idx],
                [
                    'name' => $item['name'],
                    'description' => ($item['short'] ?? '') . "\n\nПодробное описание товара. Качественный продукт с отличными характеристиками и гарантией качества от производителя. Доставка по всей России.",
                    'short_description' => $item['short'] ?? null,
                    'price' => $item['price'],
                    'old_price' => $item['old'],
                    'stock' => rand(5, 100),
                    'sku' => 'SKU-' . strtoupper(Str::random(6)),
                    'attributes' => $item['attrs'] ?? [],
                    'category_id' => $category->id,
                    'is_active' => true,
                    'is_featured' => $item['featured'] ?? false,
                    'rating' => round(mt_rand(35, 50) / 10, 2),
                    'reviews_count' => rand(0, 150),
                    'views' => rand(50, 5000),
                ]
            );

            // Add placeholder image if no images
            if ($product->images()->count() === 0) {
                $color = $placeholderColors[$idx % count($placeholderColors)];
                $text = rawurlencode(mb_substr($item['name'], 0, 30));
                $svg = "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='600' height='600'><rect fill='%23{$color}' width='600' height='600'/><text x='300' y='310' text-anchor='middle' font-family='Arial' font-size='28' fill='white' font-weight='bold'>{$text}</text></svg>";
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $svg,
                    'alt' => $item['name'],
                    'is_primary' => true,
                    'sort_order' => 0,
                ]);
            }
        }
    }
}
