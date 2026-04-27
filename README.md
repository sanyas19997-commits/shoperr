# Billaro Store

Полноценный интернет-магазин на **Laravel 10 + Vue 3 + Filament 3**, полностью на русском языке.

## Стек технологий

- **Backend:** Laravel 10 (PHP 8.1+)
- **Frontend:** Blade + Vue 3 + Vite, дизайн на основе шаблона **Kidify**
- **Админка:** Filament 3 (`/admin`)
- **БД:** MySQL 8 (продакшн) / SQLite (локально)
- **Локализация:** русский язык (UI, валидация, Filament)

## Возможности

### Витрина магазина
- Главная страница с баннером, популярными категориями, хитами и новинками
- Каталог с фильтрацией по категориям, цене, поиском и сортировкой
- Карточка товара (галерея, цена со скидкой, описание, похожие товары)
- Корзина (сессионная) с AJAX-добавлением и mini-cart на Vue 3
- Оформление заказа: контактные данные, доставка, оплата
- Личный кабинет: профиль и история заказов
- Регистрация / вход / выход
- Страницы: О магазине, Контакты, Доставка, Возврат, Конфиденциальность
- Форма обратной связи

### Админка (`/admin`)
- Управление **товарами** (фото, цена, скидка, остатки, категория, доп. изображения)
- Управление **категориями** (включая вложенные)
- **Заказы** — просмотр, смена статуса, состав заказа
- **Пользователи** — CRUD, назначение прав администратора
- **Страницы** — редактор статических страниц
- **Обращения** — сообщения с формы контактов
- **Настройки сайта** — название, телефон, email, тексты главной

## Локальная установка

```bash
git clone <repo>
cd billaro_store
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm run build
php artisan serve
```

После этого:
- Витрина: http://localhost:8000
- Админка: http://localhost:8000/admin
  - email: `admin@billaro.ru`
  - пароль: `admin123`
- Тестовый покупатель: `customer@example.com` / `password`

## Продакшн (на сервере 77.222.40.85)

В `.env` для продакшна:

```ini
APP_ENV=production
APP_DEBUG=false
APP_URL=https://store.billaro.ru
APP_LOCALE=ru

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3308
DB_DATABASE=sanyas1997_billa
DB_USERNAME=sanyas1997_billa
DB_PASSWORD=...
```

Деплой:

```bash
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan migrate --force
php artisan db:seed --force   # только при первом запуске
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Веб-сервер должен указывать в `~/billaro_store/public_html` (которая является symlink на `~/billaro_store/public`).

## Структура

```
app/
├── Filament/                  # админ-панель (ресурсы и страницы)
│   ├── Pages/SiteSettings.php
│   └── Resources/             # CategoryResource, ProductResource, OrderResource, ...
├── Http/Controllers/          # витрина (Home, Catalog, Cart, Checkout, Account)
├── Models/                    # User, Category, Product, Order, Setting, Page, ...
└── Services/CartService.php   # сессионная корзина
database/
├── migrations/                # схема БД
└── seeders/DatabaseSeeder.php # тестовые данные
resources/
├── views/                     # Blade-шаблоны
├── js/                        # Vue 3 компоненты + shop.js
└── css/shop.css               # дополнительные стили
public/kidify/                 # CSS/JS/шрифты Kidify
routes/web.php                 # публичные маршруты
```
