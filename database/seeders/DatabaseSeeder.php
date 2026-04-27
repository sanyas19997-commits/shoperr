<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@billaro.ru'],
            [
                'name' => 'Администратор',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'role' => User::ROLE_ADMIN,
            ]
        );

        // Demo manager
        User::updateOrCreate(
            ['email' => 'manager@billaro.ru'],
            [
                'name' => 'Менеджер',
                'password' => Hash::make('manager123'),
                'is_admin' => false,
                'role' => User::ROLE_MANAGER,
            ]
        );

        // Brands
        $brandNames = ['Billaro', 'KidStar', 'PlayMore', 'Sportina', 'EcoToys'];
        foreach ($brandNames as $name) {
            Brand::updateOrCreate(['name' => $name], [
                'slug' => Str::slug($name),
                'is_active' => true,
            ]);
        }

        // Demo customer
        User::updateOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Иван Покупатель',
                'phone' => '+7 (900) 123-45-67',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );

        // Settings
        $settings = [
            'site_name' => 'Billaro Store',
            'phone' => '+7 (495) 123-45-67',
            'email' => 'info@billaro.ru',
            'address' => 'г. Москва, ул. Примерная, д. 1',
            'working_hours' => 'Пн-Пт 9:00-20:00, Сб-Вс 10:00-18:00',
            'hero_title' => 'Качественные товары для всей семьи',
            'hero_subtitle' => 'Большой выбор, выгодные цены и быстрая доставка по всей России. Откройте для себя мир качественных товаров для детей и взрослых.',
            'about_text' => 'Billaro Store — это современный интернет-магазин, в котором вы найдёте всё необходимое для своей семьи. Мы тщательно отбираем поставщиков и предлагаем только проверенные товары по честным ценам. Доставляем по всей России, принимаем оплату всеми удобными способами.',
        ];
        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value, 'group' => 'general']);
        }

        // Pages
        Page::updateOrCreate(['slug' => 'delivery'], [
            'title' => 'Доставка и оплата',
            'body' => '<h3>Способы доставки</h3><ul><li>Курьерская доставка по Москве — 350 ₽, бесплатно от 5 000 ₽</li><li>Самовывоз из пункта выдачи — бесплатно</li><li>СДЭК — от 250 ₽</li><li>Почта России — от 200 ₽</li></ul><h3>Способы оплаты</h3><ul><li>Наличными при получении</li><li>Картой курьеру</li><li>Картой онлайн</li><li>Безналичный расчёт для юр. лиц</li></ul>',
            'is_active' => true,
        ]);

        Page::updateOrCreate(['slug' => 'returns'], [
            'title' => 'Возврат товара',
            'body' => '<p>В соответствии с Законом «О защите прав потребителей», вы можете вернуть товар в течение 14 дней после получения.</p><p>Для возврата необходимо сохранить товарный вид и упаковку. Подробности уточняйте у нашего менеджера по телефону.</p>',
            'is_active' => true,
        ]);

        Page::updateOrCreate(['slug' => 'privacy'], [
            'title' => 'Политика конфиденциальности',
            'body' => '<p>Мы заботимся о ваших персональных данных. Все данные хранятся в защищённом виде и не передаются третьим лицам без вашего согласия.</p>',
            'is_active' => true,
        ]);

        // Categories
        $categoriesData = [
            ['Игрушки', '🧸', [
                ['Конструкторы', null],
                ['Куклы и плюшевые', null],
                ['Развивающие игры', null],
            ]],
            ['Одежда', '👕', [
                ['Для мальчиков', null],
                ['Для девочек', null],
                ['Для малышей', null],
            ]],
            ['Обувь', '👟', []],
            ['Аксессуары', '🎒', []],
            ['Книги', '📚', []],
            ['Спорт', '⚽', []],
            ['Творчество', '🎨', []],
            ['Подарки', '🎁', []],
        ];

        $categoryMap = [];
        $sortIndex = 0;
        foreach ($categoriesData as [$name, $icon, $children]) {
            $cat = Category::updateOrCreate(
                ['slug' => Str::slug(transliterate($name))],
                [
                    'name' => $name,
                    'description' => "Категория «{$name}» в нашем магазине",
                    'sort_order' => $sortIndex++,
                    'is_active' => true,
                ]
            );
            $categoryMap[$name] = $cat;
            foreach ($children as [$childName, $_]) {
                Category::updateOrCreate(
                    ['slug' => Str::slug(transliterate($childName))],
                    [
                        'name' => $childName,
                        'parent_id' => $cat->id,
                        'is_active' => true,
                    ]
                );
            }
        }

        // Sample products
        $productsData = [
            ['Конструктор «Замок»', 'Игрушки', 2490, 1990, 'Большой пластиковый конструктор из 320 деталей. Развивает мелкую моторику и пространственное мышление.', true],
            ['Кукла «Аня»', 'Игрушки', 1890, null, 'Мягкая текстильная кукла высотой 35 см с набором сменных нарядов.', true],
            ['Деревянная пирамидка', 'Игрушки', 890, null, 'Классическая деревянная пирамидка для детей от 1 года. Натуральные материалы, безопасная краска.', false],
            ['Радиоуправляемая машина', 'Игрушки', 3490, 2790, 'Внедорожник на радиоуправлении с подсветкой и реалистичными звуками.', true],

            ['Футболка «Динозавр»', 'Одежда', 990, 690, 'Хлопковая футболка с принтом динозавра. 100% хлопок, мягкая и приятная к телу.', true],
            ['Платье «Ромашка»', 'Одежда', 2190, null, 'Лёгкое летнее платье с цветочным принтом. Идеально для прогулок и праздников.', false],
            ['Спортивный костюм', 'Одежда', 2990, 2490, 'Спортивный костюм для активных детей. Дышащая ткань, удобный крой.', true],
            ['Куртка демисезонная', 'Одежда', 4490, null, 'Тёплая и водонепроницаемая куртка для прохладной погоды.', false],

            ['Кроссовки беговые', 'Обувь', 3290, 2790, 'Лёгкие беговые кроссовки с амортизацией. Подходят для спорта и повседневной носки.', true],
            ['Сандалии летние', 'Обувь', 1890, null, 'Удобные сандалии с регулируемыми ремешками. Натуральная кожа.', false],

            ['Рюкзак школьный', 'Аксессуары', 2790, 2290, 'Эргономичный школьный рюкзак с ортопедической спинкой и светоотражающими элементами.', true],
            ['Кепка спортивная', 'Аксессуары', 690, null, 'Хлопковая кепка-бейсболка с регулируемым размером.', false],

            ['Книга «Сказки народов мира»', 'Книги', 890, null, 'Иллюстрированный сборник лучших народных сказок для семейного чтения.', false],
            ['Энциклопедия для детей', 'Книги', 1490, 990, 'Большая энциклопедия с яркими иллюстрациями. Более 500 интересных фактов.', true],

            ['Мяч футбольный', 'Спорт', 1290, null, 'Профессиональный футбольный мяч. Размер 5, прочный материал.', true],
            ['Велосипед детский', 'Спорт', 8990, 7490, 'Двухколёсный велосипед с дополнительными колёсиками для обучения.', true],

            ['Набор для рисования', 'Творчество', 1290, null, 'Большой набор с фломастерами, карандашами и красками. 96 предметов.', false],
            ['Конструктор для творчества', 'Творчество', 1690, 1290, 'Магнитный конструктор из 100 деталей для развития фантазии.', true],

            ['Подарочный набор «Радуга»', 'Подарки', 2490, null, 'Готовый подарочный набор с игрушками, сладостями и сюрпризом.', true],
            ['Открытка с конвертом', 'Подарки', 290, null, 'Красивая поздравительная открытка ручной работы.', false],
        ];

        foreach ($productsData as [$name, $catName, $price, $sale, $desc, $featured]) {
            $cat = $categoryMap[$catName] ?? null;
            Product::updateOrCreate(
                ['slug' => Str::slug(transliterate($name)) . '-' . substr(md5($name), 0, 4)],
                [
                    'category_id' => $cat?->id,
                    'name' => $name,
                    'sku' => 'BS-' . random_int(1000, 9999),
                    'price' => $price,
                    'sale_price' => $sale,
                    'stock' => random_int(5, 100),
                    'short_description' => $desc,
                    'description' => $desc . "\n\nКачественный товар от проверенного производителя. Гарантия 30 дней. Доставка по всей России.",
                    'is_active' => true,
                    'is_featured' => $featured,
                ]
            );
        }

        $this->call(\Database\Seeders\HomeContentSeeder::class);
    }
}

if (! function_exists('transliterate')) {
    function transliterate(string $str): string
    {
        $cyr = ['а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',
                'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'];
        $lat = ['a','b','v','g','d','e','yo','zh','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','sch','','y','','e','yu','ya',
                'A','B','V','G','D','E','Yo','Zh','Z','I','Y','K','L','M','N','O','P','R','S','T','U','F','H','C','Ch','Sh','Sch','','Y','','E','Yu','Ya'];

        return str_replace($cyr, $lat, $str);
    }
}
