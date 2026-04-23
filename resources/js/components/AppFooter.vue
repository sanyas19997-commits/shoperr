<template>
    <footer class="footer mt-auto">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <router-link :to="{ name: 'home' }" class="footer-logo d-inline-flex align-items-center gap-2 text-decoration-none">
                        <i class="bi bi-bag-heart-fill text-warning"></i>
                        <span>Shop<span class="text-warning">Hub</span></span>
                    </router-link>
                    <div class="hotline-num mb-1">
                        <a href="tel:+78000000000">+7 (800) 000-00-00</a>
                    </div>
                    <div class="small text-muted mb-2">Поддержка 24/7 — пн–вс, 9:00–21:00</div>
                    <ul class="list-unstyled small mb-0">
                        <li><i class="bi bi-geo-alt me-2"></i>Москва, ул. Примерная, 1</li>
                        <li><i class="bi bi-envelope me-2"></i><a href="mailto:support@shophub.test">support@shophub.test</a></li>
                    </ul>
                    <div class="social-links">
                        <a href="https://www.facebook.com/" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="https://twitter.com/" target="_blank" rel="noopener" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                        <a href="https://www.instagram.com/" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="https://www.youtube.com/" target="_blank" rel="noopener" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <h6>Покупателям</h6>
                    <ul class="list-unstyled">
                        <li><router-link :to="{ name: 'catalog' }" active-class="active" exact-active-class="active">Каталог</router-link></li>
                        <li><router-link :to="{ name: 'delivery' }" active-class="active" exact-active-class="active">Доставка</router-link></li>
                        <li><router-link :to="{ name: 'payment' }" active-class="active" exact-active-class="active">Оплата</router-link></li>
                        <li><router-link :to="{ name: 'returns' }" active-class="active" exact-active-class="active">Возврат</router-link></li>
                        <li><router-link :to="{ name: 'contacts', hash: '#feedback' }" active-class="" exact-active-class="">Задать вопрос</router-link></li>
                    </ul>
                </div>
                <div class="col-md-2 col-6">
                    <h6>Компания</h6>
                    <ul class="list-unstyled">
                        <li><router-link :to="{ name: 'about' }" active-class="active" exact-active-class="active">О нас</router-link></li>
                        <li><router-link :to="{ name: 'contacts' }" active-class="active" exact-active-class="active">Контакты</router-link></li>
                        <li><router-link :to="{ name: 'delivery' }" active-class="" exact-active-class="">Оплата и доставка</router-link></li>
                        <li><router-link :to="{ name: 'returns' }" active-class="" exact-active-class="">Политика возврата</router-link></li>
                    </ul>
                </div>
                <div class="col-md-2 col-6">
                    <h6>Мой аккаунт</h6>
                    <ul class="list-unstyled">
                        <li><router-link :to="{ name: 'profile' }" active-class="active" exact-active-class="active">Профиль</router-link></li>
                        <li><router-link :to="{ name: 'orders' }" active-class="active" exact-active-class="active">Мои заказы</router-link></li>
                        <li><router-link :to="{ name: 'favorites' }" active-class="active" exact-active-class="active">Избранное</router-link></li>
                        <li><router-link :to="{ name: 'cart' }" active-class="active" exact-active-class="active">Корзина</router-link></li>
                    </ul>
                </div>
                <div class="col-md-2 col-6">
                    <h6>Свяжитесь</h6>
                    <ul class="list-unstyled">
                        <li><router-link :to="{ name: 'contacts' }" active-class="active" exact-active-class="active">Написать нам</router-link></li>
                        <li v-if="auth.isAuthenticated">
                            <router-link :to="{ name: 'profile', query: { tab: 'support' } }" active-class="" exact-active-class="">Чат с поддержкой</router-link>
                        </li>
                        <li v-else>
                            <router-link :to="{ name: 'login', query: { redirect: '/profile?tab=support' } }" active-class="" exact-active-class="">Чат с поддержкой</router-link>
                        </li>
                        <li><a href="tel:+78000000000">+7 (800) 000-00-00</a></li>
                    </ul>
                </div>
            </div>

            <!-- Category rows — loaded from real categories so links actually filter the catalog. -->
            <div v-if="featuredGroups.length" class="footer-cats">
                <div v-for="group in featuredGroups" :key="group.id" class="fc-group">
                    <router-link :to="{ name: 'category', params: { slug: group.slug } }"
                                 class="fc-label"
                                 active-class=""
                                 exact-active-class="">{{ group.name }}:</router-link>
                    <span class="fc-list">
                        <router-link v-for="child in group.children" :key="child.id"
                                     :to="{ name: 'category', params: { slug: child.slug } }"
                                     active-class=""
                                     exact-active-class="">{{ child.name }}</router-link>
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
import { computed, onMounted, ref } from 'vue';
import api from '../api';
import { useAuthStore } from '../stores/auth';

const auth = useAuthStore();
const year = computed(() => new Date().getFullYear());
const tree = ref([]);

// Show up to 3 root categories that have at least one child — the intent of
// the hand-rolled "Электроника / Дом и Сад / Здоровье и красота" rows in the
// Martfury template. If fewer exist, we just render what we have. Falling
// back to the raw root if it has no children keeps the row non-empty.
const featuredGroups = computed(() => {
    const withChildren = tree.value.filter((c) => Array.isArray(c.children) && c.children.length > 0);
    const pool = withChildren.length >= 3 ? withChildren : tree.value;
    return pool.slice(0, 3).map((c) => ({
        id: c.id,
        name: c.name,
        slug: c.slug,
        children: (c.children || []).slice(0, 8),
    }));
});

onMounted(async () => {
    try {
        // `tree=true` is the shape the navbar mega-menu already uses.
        const { data } = await api.get('/categories', { params: { tree: true }, silent: true });
        tree.value = data?.data ?? data ?? [];
    } catch (_) {
        tree.value = [];
    }
});
</script>

<style scoped>
.footer-logo {
    font-weight: 700;
    font-size: 1.3rem;
    color: #fff;
}
.hotline-num a {
    color: #fff;
    font-weight: 700;
    font-size: 1.15rem;
    text-decoration: none;
}
.footer-cats .fc-label {
    font-weight: 600;
    color: #fff;
    text-decoration: none;
    margin-right: 0.5rem;
}
.footer-cats .fc-label:hover { color: var(--bs-warning, #fdb827); }
</style>
