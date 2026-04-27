<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\InstagramPost;
use App\Models\MenuItem;
use App\Models\Setting;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class HomeContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedBanners();
        $this->seedTestimonials();
        $this->seedInstagram();
        $this->seedMenu();
        $this->seedHomeTexts();
    }

    private function seedBanners(): void
    {
        $banners = [
            // Hero swiper (section banner-homepage1)
            ['place' => 'hero_slide', 'sort_order' => 1, 'title' => 'Зима', 'subtitle' => 'Распродажа',
                'label' => 'Всё для вашего малыша', 'image' => 'kidify/assets/imgs/page/homepage1/banner.png',
                'link' => '/catalog', 'button_text' => 'Смотреть скидки'],
            ['place' => 'hero_slide', 'sort_order' => 2, 'title' => 'Лето', 'subtitle' => 'Новинки',
                'label' => 'Одежда для активных детей', 'image' => 'kidify/assets/imgs/page/homepage1/banner2.png',
                'link' => '/catalog', 'button_text' => 'Смотреть все'],
            // Block-section-4 deal banners (left "Для девочек", right "Топ бренды")
            ['place' => 'deal_left', 'sort_order' => 1, 'title' => 'Для девочек',
                'subtitle' => 'Скидка до 50% на премиальную детскую одежду. Спешите!',
                'image' => 'kidify/assets/imgs/page/homepage1/star2.png',
                'link' => '/catalog', 'button_text' => 'В магазин'],
            ['place' => 'deal_right', 'sort_order' => 1, 'title' => 'Топ бренды',
                'subtitle' => 'Новые бренды этого сезона. Скидки до 35%',
                'image' => 'kidify/assets/imgs/page/homepage1/star.png',
                'link' => '/catalog', 'button_text' => 'В магазин'],
            // Block-section-6 animal-kids banner (big CTA)
            ['place' => 'animal_kids', 'sort_order' => 1, 'title' => 'Коллекция "Животные"',
                'subtitle' => 'Игрушки и одежда с любимыми героями',
                'price_label' => 'Скидки до 40%',
                'image' => 'kidify/assets/imgs/page/homepage1/banner3.png',
                'link' => '/catalog', 'button_text' => 'Смотреть коллекцию'],
            // Block-section-2 promo
            ['place' => 'promo_bg', 'sort_order' => 1, 'title' => 'Спецпредложение',
                'subtitle' => 'Скидки на популярные категории',
                'image' => 'kidify/assets/imgs/page/homepage1/bg-section2.png',
                'link' => '/catalog', 'button_text' => 'Подробнее'],
        ];
        foreach ($banners as $b) {
            Banner::updateOrCreate(
                ['place' => $b['place'], 'sort_order' => $b['sort_order']],
                array_merge(['is_active' => true], $b)
            );
        }
    }

    private function seedTestimonials(): void
    {
        $items = [
            ['name' => 'Анна Петрова', 'role' => 'Мама двоих детей',
                'avatar' => 'kidify/assets/imgs/page/homepage1/author1.png',
                'text' => 'Отличный магазин! Быстрая доставка, качественные товары. Детям нравится всё, что я здесь покупаю.',
                'rating' => 5, 'sort_order' => 1],
            ['name' => 'Ольга Смирнова', 'role' => 'Молодая мама',
                'avatar' => 'kidify/assets/imgs/page/homepage1/author2.png',
                'text' => 'Заказываю уже не в первый раз. Большой выбор, приятные цены и всегда помогут с выбором.',
                'rating' => 5, 'sort_order' => 2],
            ['name' => 'Мария Иванова', 'role' => 'Мама трёх малышей',
                'avatar' => 'kidify/assets/imgs/page/homepage1/author3.png',
                'text' => 'Покупаю здесь одежду, игрушки, школьные товары — всё в одном месте. Очень удобно!',
                'rating' => 5, 'sort_order' => 3],
            ['name' => 'Елена Соколова', 'role' => 'Постоянный клиент',
                'avatar' => 'kidify/assets/imgs/page/homepage1/author4.png',
                'text' => 'Лучший магазин детских товаров в городе. Рекомендую всем своим подругам!',
                'rating' => 5, 'sort_order' => 4],
        ];
        foreach ($items as $t) {
            Testimonial::updateOrCreate(['sort_order' => $t['sort_order']], array_merge(['is_active' => true], $t));
        }
    }

    private function seedInstagram(): void
    {
        $images = [
            'kidify/assets/imgs/page/homepage1/instagram6.png',
            'kidify/assets/imgs/page/homepage1/instagram.png',
            'kidify/assets/imgs/page/homepage1/instagram2.png',
            'kidify/assets/imgs/page/homepage1/instagram3.png',
            'kidify/assets/imgs/page/homepage1/instagram4.png',
            'kidify/assets/imgs/page/homepage1/instagram5.png',
        ];
        foreach ($images as $i => $img) {
            InstagramPost::updateOrCreate(
                ['sort_order' => $i + 1],
                [
                    'image' => $img,
                    'link' => 'https://instagram.com/',
                    'is_active' => true,
                ]
            );
        }
    }

    private function seedMenu(): void
    {
        $header = [
            ['title' => 'Главная', 'url' => '/', 'sort_order' => 1],
            ['title' => 'Каталог', 'url' => '/catalog', 'sort_order' => 2],
            ['title' => 'Блог', 'url' => '/blog', 'sort_order' => 3],
            ['title' => 'О магазине', 'url' => '/about', 'sort_order' => 4],
            ['title' => 'Контакты', 'url' => '/contact', 'sort_order' => 5],
        ];
        foreach ($header as $m) {
            MenuItem::updateOrCreate(
                ['placement' => 'header', 'sort_order' => $m['sort_order']],
                array_merge(['placement' => 'header', 'is_active' => true, 'open_new_tab' => false], $m)
            );
        }

        $footerShop = [
            ['title' => 'Каталог', 'url' => '/catalog', 'sort_order' => 1],
            ['title' => 'Новинки', 'url' => '/catalog?sort=new', 'sort_order' => 2],
            ['title' => 'Скидки', 'url' => '/catalog?sort=sale', 'sort_order' => 3],
            ['title' => 'Бренды', 'url' => '/catalog?brands=all', 'sort_order' => 4],
        ];
        foreach ($footerShop as $m) {
            MenuItem::updateOrCreate(
                ['placement' => 'footer_shop', 'sort_order' => $m['sort_order']],
                array_merge(['placement' => 'footer_shop', 'is_active' => true, 'open_new_tab' => false], $m)
            );
        }

        $footerCustomers = [
            ['title' => 'Мой аккаунт', 'url' => '/account', 'sort_order' => 1],
            ['title' => 'Корзина', 'url' => '/cart', 'sort_order' => 2],
            ['title' => 'Оформление заказа', 'url' => '/checkout', 'sort_order' => 3],
            ['title' => 'Вход / Регистрация', 'url' => '/login', 'sort_order' => 4],
        ];
        foreach ($footerCustomers as $m) {
            MenuItem::updateOrCreate(
                ['placement' => 'footer_customers', 'sort_order' => $m['sort_order']],
                array_merge(['placement' => 'footer_customers', 'is_active' => true, 'open_new_tab' => false], $m)
            );
        }

        $footerHelp = [
            ['title' => 'О магазине', 'url' => '/about', 'sort_order' => 1],
            ['title' => 'Контакты', 'url' => '/contact', 'sort_order' => 2],
            ['title' => 'Блог', 'url' => '/blog', 'sort_order' => 3],
            ['title' => 'Доставка и оплата', 'url' => '/about', 'sort_order' => 4],
        ];
        foreach ($footerHelp as $m) {
            MenuItem::updateOrCreate(
                ['placement' => 'footer_help', 'sort_order' => $m['sort_order']],
                array_merge(['placement' => 'footer_help', 'is_active' => true, 'open_new_tab' => false], $m)
            );
        }
    }

    private function seedHomeTexts(): void
    {
        $defaults = [
            'home_featured_title' => 'Рекомендуемые товары',
            'home_newest_title' => 'Новинки',
            'home_popular_title' => 'Популярные товары',
            'home_deal_title' => 'Горячие предложения',
            'home_testimonials_title' => 'Отзывы наших клиентов',
            'home_instagram_title' => 'Мы в Instagram',
            'home_categories_title' => 'Категории',
            'home_brands_title' => 'Наши бренды',
            'home_best_sellers_title' => 'Хиты продаж',
        ];
        foreach ($defaults as $key => $value) {
            if (!Setting::where('key', $key)->exists()) {
                Setting::set($key, $value);
            }
        }
    }
}
