<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Летняя распродажа',
                'subtitle' => 'Скидки до 50% на тысячи товаров',
                'image' => 'https://images.unsplash.com/photo-1607083206869-4c7672e72a8a?w=1600&h=600&fit=crop',
                'url' => '/catalog',
                'sort_order' => 0,
                'is_active' => true,
            ],
            [
                'title' => 'Новая коллекция одежды',
                'subtitle' => 'Стильные образы для любого случая',
                'image' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=1600&h=600&fit=crop',
                'url' => '/catalog/odezhda',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Техника для жизни',
                'subtitle' => 'Новинки электроники со скидкой',
                'image' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=1600&h=600&fit=crop',
                'url' => '/catalog/elektronika',
                'sort_order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::updateOrCreate(['title' => $banner['title']], $banner);
        }
    }
}
