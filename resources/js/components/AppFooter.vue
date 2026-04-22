<template>
    <footer class="footer mt-auto">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h5 class="text-white mb-3"><i class="bi bi-bag-fill me-2"></i>ShopHub</h5>
                    <p class="small">Современный интернет-магазин с широким ассортиментом товаров, быстрой доставкой и удобным оформлением заказа.</p>
                </div>
                <div class="col-md-2 col-6">
                    <h6 class="text-white mb-3">Покупателям</h6>
                    <ul class="list-unstyled small">
                        <li><router-link :to="{ name: 'catalog' }">Каталог</router-link></li>
                        <li><a href="#">Доставка</a></li>
                        <li><a href="#">Оплата</a></li>
                        <li><a href="#">Возврат</a></li>
                    </ul>
                </div>
                <div class="col-md-2 col-6">
                    <h6 class="text-white mb-3">Аккаунт</h6>
                    <ul class="list-unstyled small">
                        <li><router-link :to="{ name: 'login' }">Войти</router-link></li>
                        <li><router-link :to="{ name: 'register' }">Регистрация</router-link></li>
                        <li><router-link :to="{ name: 'orders' }">Мои заказы</router-link></li>
                        <li><router-link :to="{ name: 'favorites' }">Избранное</router-link></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="text-white mb-3">Контакты</h6>
                    <ul class="list-unstyled small">
                        <li><i class="bi bi-telephone me-2"></i>+7 (800) 000-00-00</li>
                        <li><i class="bi bi-envelope me-2"></i>support@shophub.test</li>
                        <li><i class="bi bi-geo-alt me-2"></i>Москва, ул. Примерная, 1</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 border-secondary" />
            <div class="small text-center opacity-75">
                © {{ new Date().getFullYear() }} ShopHub. Все права защищены.
            </div>
        </div>
    </footer>
</template>
