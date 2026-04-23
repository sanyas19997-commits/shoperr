# ShopHub — Интернет-магазин на Laravel 10 + Vue 3

Полноценный интернет-магазин с REST API на Laravel, SPA-фронтендом на Vue 3 и полной админ-панелью. Проект демонстрирует архитектуру и функционал коммерческого e-commerce решения (уровень «Wildberries / Ozon light»).

## ✨ Возможности

### Для покупателей
- 🏠 **Главная страница** — карусель баннеров, категории, хиты продаж и новинки
- 🛍️ **Каталог** — фильтры (категория, цена, наличие), сортировка, поиск, пагинация
- 📦 **Карточка товара** — галерея, характеристики, рейтинг, отзывы, похожие товары
- 🧺 **Корзина** — для гостей (сессия) и авторизованных пользователей (БД) с автосклейкой при логине
- 💳 **Оформление заказа** — контактные данные, адрес, комментарий, статусы
- 👤 **Личный кабинет** — профиль, история заказов, смена пароля, избранное
- ❤️ **Избранное** — добавление/удаление товаров в wishlist
- ⭐ **Отзывы и рейтинги** — оценки и комментарии к товарам

### Для администраторов
- 📊 **Дашборд** — статистика (пользователи, товары, заказы, выручка), топ товары, последние заказы
- 📦 **Управление товарами** — CRUD, загрузка изображений, цены/скидки, атрибуты, остатки
- 📁 **Категории** — иерархическая структура (подкатегории) с CRUD
- 📋 **Заказы** — просмотр, фильтрация, изменение статуса, детали
- 👥 **Пользователи** — список, изменение роли, удаление
- 🎨 **Баннеры** — управление главными баннерами

### Технические возможности
- 🔐 Авторизация через Laravel Sanctum (cookie-based SPA)
- 🌐 Полноценный REST API
- 📱 Адаптивный дизайн (mobile-first на Bootstrap 5)
- 🗂️ Ленивая загрузка страниц через Vue Router
- 🔒 CSRF защита, хеширование паролей
- 💾 Сессионная корзина для гостей

## 🛠️ Технологии

| Слой      | Технологии                                   |
|-----------|----------------------------------------------|
| Backend   | PHP 8.1+, Laravel 10, Sanctum                |
| Frontend  | Vue 3 (Composition API), Vite, Pinia, Vue Router |
| UI        | Bootstrap 5, Bootstrap Icons, SCSS           |
| БД        | SQLite (по умолчанию) / MySQL                |
| HTTP      | Axios                                        |

## 📋 Требования

- **PHP ≥ 8.1** c расширениями: `mbstring`, `xml`, `sqlite3` (или `mysql`), `curl`, `gd`/`intl` (опц.)
- **Composer ≥ 2.x**
- **Node.js ≥ 18** и **npm ≥ 9**

## 🚀 Установка

### 1. Клонирование

```bash
git clone <repo-url>
cd ecommerce
```

### 2. Backend (Laravel)

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan storage:link
```

Это создаст базу данных SQLite и наполнит её демо-данными:
- админ: `admin@shophub.test` / `password`
- пользователь: `user@shophub.test` / `password`
- ~28 демо-товаров, 20+ категорий и 3 баннера

### 3. Frontend (Vue)

```bash
npm install
npm run build    # production build
# или для разработки:
npm run dev
```

### 4. Запуск

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Откройте http://localhost:8000 — SPA и API обслуживаются с одного origin.

#### Режим разработки с HMR

В одном терминале:
```bash
php artisan serve
```
В другом:
```bash
npm run dev
```
Laravel Vite plugin подключит HMR автоматически.

## 🗄️ Структура БД

| Таблица          | Назначение                                           |
|------------------|------------------------------------------------------|
| `users`          | Пользователи (роль: admin/user)                     |
| `categories`     | Категории (parent_id для иерархии)                  |
| `products`       | Товары                                              |
| `product_images` | Изображения товаров                                 |
| `carts`          | Корзины (для гостей — по session_id)                |
| `cart_items`     | Позиции корзины                                     |
| `orders`         | Заказы со статусами                                 |
| `order_items`    | Позиции заказа                                      |
| `reviews`        | Отзывы к товарам                                    |
| `favorites`      | Избранное                                           |
| `banners`        | Баннеры на главной                                  |

## 🔌 API — основные эндпоинты

### Публичные

| Метод | URL                         | Назначение                                   |
|-------|-----------------------------|----------------------------------------------|
| GET   | `/api/categories`           | Список категорий (`?tree=1` — только корни)  |
| GET   | `/api/products`             | Каталог (фильтры/сортировка/поиск/пагинация) |
| GET   | `/api/products/{slug}`      | Карточка товара + похожие                    |
| GET   | `/api/products/{id}/reviews`| Отзывы о товаре                              |
| GET   | `/api/cart`                 | Корзина (гостевая или пользовательская)      |
| POST  | `/api/cart`                 | Добавить в корзину                           |
| PUT   | `/api/cart/items/{id}`      | Изменить количество                          |
| DELETE| `/api/cart/items/{id}`      | Удалить позицию                              |
| DELETE| `/api/cart`                 | Очистить корзину                             |
| GET   | `/api/banners`              | Активные баннеры                             |
| POST  | `/api/register`             | Регистрация                                  |
| POST  | `/api/login`                | Вход                                         |
| POST  | `/api/forgot-password`      | Запрос сброса                                |
| POST  | `/api/reset-password`       | Сброс пароля                                 |

### Требуют авторизации

| Метод | URL                              | Назначение                  |
|-------|----------------------------------|-----------------------------|
| GET   | `/api/me`                        | Текущий пользователь        |
| POST  | `/api/logout`                    | Выход                       |
| GET   | `/api/profile`                   | Профиль                     |
| PUT   | `/api/profile`                   | Обновить профиль            |
| PUT   | `/api/profile/password`          | Сменить пароль              |
| GET   | `/api/orders`                    | История заказов             |
| POST  | `/api/orders`                    | Создать заказ               |
| GET   | `/api/orders/{id}`               | Детали заказа               |
| POST  | `/api/products/{id}/reviews`     | Оставить отзыв              |
| GET   | `/api/favorites`                 | Список избранного           |
| POST  | `/api/favorites/{id}/toggle`     | Добавить/убрать из избранного |

### Админские (роль `admin`)

| Метод | URL                                    | Назначение                   |
|-------|----------------------------------------|------------------------------|
| GET   | `/api/admin/dashboard`                 | Статистика                   |
| CRUD  | `/api/admin/products`                  | Управление товарами          |
| CRUD  | `/api/admin/categories`                | Управление категориями       |
| GET   | `/api/admin/orders`                    | Список заказов               |
| PUT   | `/api/admin/orders/{id}/status`        | Обновить статус              |
| CRUD  | `/api/admin/users`                     | Пользователи                 |
| CRUD  | `/api/admin/banners`                   | Баннеры                      |

## 🧑‍💻 Демо-доступы

После `php artisan db:seed`:

- **Админ:** `admin@shophub.test` / `password`
- **Покупатель:** `user@shophub.test` / `password`

Админ-панель доступна по адресу `/admin` после входа.

## 📁 Структура проекта

```
├── app/
│   ├── Http/
│   │   ├── Controllers/Api/          # Публичные API контроллеры
│   │   │   └── Admin/                # Админские API контроллеры
│   │   ├── Middleware/EnsureAdmin.php
│   │   └── Resources/                # API ресурсы (сериализация)
│   ├── Models/                       # Eloquent модели
│   └── Services/CartService.php
├── database/
│   ├── migrations/                   # Миграции
│   ├── seeders/                      # Сидеры
│   └── database.sqlite
├── resources/
│   ├── css/app.scss                  # Bootstrap + кастом
│   ├── js/
│   │   ├── components/               # Vue компоненты
│   │   ├── pages/                    # Страницы (public + admin)
│   │   ├── stores/                   # Pinia stores
│   │   ├── router.js
│   │   ├── api.js
│   │   └── app.js
│   └── views/app.blade.php           # SPA shell
├── routes/
│   ├── api.php                       # API маршруты
│   └── web.php                       # SPA fallback
└── public/build/                     # Скомпилированные assets
```

## 🔐 Безопасность

- CSRF защита через Laravel middleware
- Sanctum cookie-based auth для SPA (без токенов в localStorage)
- Хеширование паролей (bcrypt)
- Role-based middleware `admin` для админских эндпоинтов
- Валидация всех входных данных через Form Request
- Eloquent ORM защищает от SQL-инъекций

## 📝 Лицензия

MIT.
