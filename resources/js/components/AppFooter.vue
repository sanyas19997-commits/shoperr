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
                        <li><router-link :to="{ name: 'delivery' }">Доставка</router-link></li>
                        <li><router-link :to="{ name: 'payment' }">Оплата</router-link></li>
                        <li><router-link :to="{ name: 'returns' }">Возврат</router-link></li>
                    </ul>
                </div>
                <div class="col-md-2 col-6">
                    <h6 class="text-white mb-3">Компания</h6>
                    <ul class="list-unstyled small">
                        <li><router-link :to="{ name: 'about' }">О нас</router-link></li>
                        <li><router-link :to="{ name: 'contacts' }">Контакты</router-link></li>
                        <li><router-link :to="{ name: 'orders' }">Мои заказы</router-link></li>
                        <li><router-link :to="{ name: 'favorites' }">Избранное</router-link></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="text-white mb-3">Связаться с нами</h6>
                    <ul class="list-unstyled small">
                        <li><i class="bi bi-telephone me-2"></i>+7 (800) 000-00-00</li>
                        <li><i class="bi bi-envelope me-2"></i>support@shophub.test</li>
                        <li><i class="bi bi-geo-alt me-2"></i>Москва, ул. Примерная, 1</li>
                        <li class="mt-2">
                            <router-link :to="{ name: 'contacts' }" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-chat-dots me-1"></i>Написать нам
                            </router-link>
                        </li>
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
