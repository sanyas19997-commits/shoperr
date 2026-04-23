<template>
    <footer class="footer mt-auto">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="footer-logo d-flex align-items-center gap-2">
                        <i class="bi bi-bag-heart-fill text-warning"></i>
                        <span>Shop<span class="text-warning">Hub</span></span>
                    </div>
                    <div class="hotline-num mb-1">1900 - 1234</div>
                    <div class="small text-muted mb-2">Поддержка 24/7 — пн–вс, 9:00–21:00</div>
                    <ul class="list-unstyled small mb-0">
                        <li><i class="bi bi-geo-alt me-2"></i>Москва, ул. Примерная, 1</li>
                        <li><i class="bi bi-envelope me-2"></i>support@shophub.test</li>
                    </ul>
                    <div class="social-links">
                        <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <h6>Покупателям</h6>
                    <ul class="list-unstyled">
                        <li><router-link :to="{ name: 'catalog' }">Каталог</router-link></li>
                        <li><router-link :to="{ name: 'delivery' }">Доставка</router-link></li>
                        <li><router-link :to="{ name: 'payment' }">Оплата</router-link></li>
                        <li><router-link :to="{ name: 'returns' }">Возврат</router-link></li>
                        <li><router-link :to="{ name: 'contacts' }">FAQ</router-link></li>
                    </ul>
                </div>
                <div class="col-md-2 col-6">
                    <h6>Компания</h6>
                    <ul class="list-unstyled">
                        <li><router-link :to="{ name: 'about' }">О нас</router-link></li>
                        <li><router-link :to="{ name: 'contacts' }">Контакты</router-link></li>
                        <li><router-link :to="{ name: 'catalog' }">Партнёрская программа</router-link></li>
                        <li><router-link :to="{ name: 'catalog' }">Карьера</router-link></li>
                        <li><router-link :to="{ name: 'returns' }">Политика конфиденциальности</router-link></li>
                    </ul>
                </div>
                <div class="col-md-2 col-6">
                    <h6>Мой аккаунт</h6>
                    <ul class="list-unstyled">
                        <li><router-link :to="{ name: 'profile' }">Профиль</router-link></li>
                        <li><router-link :to="{ name: 'orders' }">Мои заказы</router-link></li>
                        <li><router-link :to="{ name: 'favorites' }">Избранное</router-link></li>
                        <li><router-link :to="{ name: 'cart' }">Корзина</router-link></li>
                    </ul>
                </div>
                <div class="col-md-2 col-6">
                    <h6>Свяжитесь</h6>
                    <ul class="list-unstyled">
                        <li><router-link :to="{ name: 'contacts' }">Написать нам</router-link></li>
                        <li><router-link :to="{ name: 'profile' }">Чат с поддержкой</router-link></li>
                        <li>+7 (800) 000-00-00</li>
                    </ul>
                </div>
            </div>

            <!-- Category rows (Martfury-style) -->
            <div class="footer-cats">
                <div class="fc-group">
                    <span class="fc-label">Электроника:</span>
                    <span class="fc-list">
                        <router-link to="/catalog">Смартфоны</router-link>
                        <router-link to="/catalog">Ноутбуки</router-link>
                        <router-link to="/catalog">Аудио</router-link>
                        <router-link to="/catalog">Компьютерные компоненты</router-link>
                        <router-link to="/catalog">Фото и видео</router-link>
                        <router-link to="/catalog">ТВ и мониторы</router-link>
                        <router-link to="/catalog">Аксессуары</router-link>
                    </span>
                </div>
                <div class="fc-group">
                    <span class="fc-label">Дом и Сад:</span>
                    <span class="fc-list">
                        <router-link to="/catalog">Мебель</router-link>
                        <router-link to="/catalog">Освещение</router-link>
                        <router-link to="/catalog">Декор</router-link>
                        <router-link to="/catalog">Кухня</router-link>
                        <router-link to="/catalog">Спальня</router-link>
                        <router-link to="/catalog">Ванна</router-link>
                    </span>
                </div>
                <div class="fc-group">
                    <span class="fc-label">Здоровье и красота:</span>
                    <span class="fc-list">
                        <router-link to="/catalog">Косметика</router-link>
                        <router-link to="/catalog">Уход за кожей</router-link>
                        <router-link to="/catalog">Уход за волосами</router-link>
                        <router-link to="/catalog">Витамины</router-link>
                        <router-link to="/catalog">Спорт и фитнес</router-link>
                    </span>
                </div>
            </div>

            <div class="copyright">
                <div>© {{ year }} ShopHub. Все права защищены.</div>
                <div class="payment-methods">
                    <span class="pm">VISA</span>
                    <span class="pm">MC</span>
                    <span class="pm">МИР</span>
                    <span class="pm">SBP</span>
                    <span class="pm">APAY</span>
                    <span class="pm">GPAY</span>
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { computed } from 'vue';
const year = computed(() => new Date().getFullYear());
</script>
