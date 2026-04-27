<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $t) {
            $t->id();
            $t->string('place', 50)->index(); // hero_slide, promo_left, promo_right, deal_banner, animal_kids, section_bg
            $t->string('title')->nullable();
            $t->string('subtitle')->nullable();
            $t->string('label')->nullable();
            $t->string('price_label')->nullable();
            $t->string('image')->nullable();
            $t->string('link')->nullable();
            $t->string('button_text')->nullable();
            $t->unsignedInteger('sort_order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('role')->nullable();
            $t->string('avatar')->nullable();
            $t->text('text');
            $t->unsignedTinyInteger('rating')->default(5);
            $t->unsignedInteger('sort_order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        Schema::create('instagram_posts', function (Blueprint $t) {
            $t->id();
            $t->string('image');
            $t->string('link')->nullable();
            $t->unsignedInteger('sort_order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        Schema::create('menu_items', function (Blueprint $t) {
            $t->id();
            $t->string('placement', 30)->default('header'); // header, footer_shop, footer_customers, footer_help, mobile
            $t->string('title');
            $t->string('url');
            $t->unsignedInteger('sort_order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->boolean('open_new_tab')->default(false);
            $t->timestamps();
            $t->index(['placement', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
        Schema::dropIfExists('instagram_posts');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('banners');
    }
};
