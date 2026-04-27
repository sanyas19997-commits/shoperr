<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import Price from './Price.vue';

const page = usePage();
const site = computed(() => page.props.site || {});
const cart = computed(() => page.props.cart || { count: 0, subtotal: 0 });
const auth = computed(() => page.props.auth || {});
const cats = computed(() => page.props.mainCategories || []);

function isActive(prefix) {
    return (page.url || '').startsWith(prefix);
}
function phoneHref(p) { return 'tel:' + (p || '').replace(/[^0-9+]/g, ''); }

function toggleMobile(e) {
    e.preventDefault();
    document.body.classList.toggle('mobile-menu-active');
}
function closeMobile(e) {
    e.preventDefault();
    document.body.classList.remove('mobile-menu-active');
}
</script>

<template>
    <header class="header sticky-bar header-style-1">
        <div class="box-top-header">
            <div class="container">
                <div class="top-header">
                    <div class="top-menu">
                        <ul class="menu-top">
                            <li><Link href="/about">О магазине</Link></li>
                            <li><Link href="/contact">Контакты</Link></li>
                            <li><Link href="/catalog">Открыть магазин</Link></li>
                        </ul>
                    </div>
                    <div class="header-top-info">
                        <span class="mr-10">{{ site.free_shipping_text }}</span>
                        <Link class="btn btn-brand-3-sm" href="/catalog">Подробнее</Link>
                    </div>
                    <div class="lang-currency">
                        <span class="mr-10">📞 <a :href="phoneHref(site.phone)" style="color:inherit;text-decoration:none;">{{ site.phone }}</a></span>
                        <span>RUB ₽</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="main-header">
                <div class="header-logo">
                    <Link class="d-flex align-items-center" href="/">
                        <img alt="" src="/kidify/assets/imgs/template/logo.svg" onerror="this.style.display='none'">
                        <strong style="font-size:22px;color:#0E0E0E;margin-left:8px;">{{ site.name }}</strong>
                    </Link>
                </div>
                <div class="header-menu">
                    <div class="header-nav">
                        <nav class="nav-main-menu d-none d-xl-block">
                            <ul class="main-menu">
                                <li><Link :class="{ active: $page.url === '/' }" href="/">Главная</Link></li>
                                <li class="has-mega-menu">
                                    <Link :class="{ active: isActive('/catalog') }" href="/catalog">Каталог</Link>
                                </li>
                                <li><Link href="/about">О магазине</Link></li>
                                <li><Link href="/contact">Контакты</Link></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="header-shop">
                    <div class="header-search">
                        <form class="form-search d-none d-md-flex" action="/catalog" method="GET">
                            <div class="select-category">
                                <select class="form-control select-active" name="category" disabled>
                                    <option value="">Все категории</option>
                                    <option v-for="c in cats" :key="c.id" :value="c.slug">{{ c.name }}</option>
                                </select>
                            </div>
                            <input type="text" name="q" placeholder="Поиск товаров...">
                            <button type="submit"><img src="/kidify/assets/imgs/template/icons/search.svg" alt="Поиск"></button>
                        </form>
                    </div>
                    <div class="header-list-icons">
                        <Link v-if="auth.user" class="account-icon account" href="/account" title="Личный кабинет">
                            <svg width="28" height="28" viewBox="0 0 28 28" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 24C6 21.8783 6.84285 19.8434 8.34315 18.3431C9.84344 16.8429 11.8783 16 14 16C16.1217 16 18.1566 16.8429 19.6569 18.3431C21.1571 19.8434 22 21.8783 22 24H20C20 22.4087 19.3679 20.8826 18.2426 19.7574C17.1174 18.6321 15.5913 18 14 18C12.4087 18 10.8826 18.6321 9.75736 19.7574C8.63214 20.8826 8 22.4087 8 24H6ZM14 15C10.685 15 8 12.315 8 9C8 5.685 10.685 3 14 3C17.315 3 20 5.685 20 9C20 12.315 17.315 15 14 15ZM14 13C16.21 13 18 11.21 18 9C18 6.79 16.21 5 14 5C11.79 5 10 6.79 10 9C10 11.21 11.79 13 14 13Z" />
                            </svg>
                        </Link>
                        <Link v-else class="account-icon account" href="/login" title="Войти">
                            <svg width="28" height="28" viewBox="0 0 28 28" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 24C6 21.8783 6.84285 19.8434 8.34315 18.3431C9.84344 16.8429 11.8783 16 14 16C16.1217 16 18.1566 16.8429 19.6569 18.3431C21.1571 19.8434 22 21.8783 22 24H20C20 22.4087 19.3679 20.8826 18.2426 19.7574C17.1174 18.6321 15.5913 18 14 18C12.4087 18 10.8826 18.6321 9.75736 19.7574C8.63214 20.8826 8 22.4087 8 24H6ZM14 15C10.685 15 8 12.315 8 9C8 5.685 10.685 3 14 3C17.315 3 20 5.685 20 9C20 12.315 17.315 15 14 15ZM14 13C16.21 13 18 11.21 18 9C18 6.79 16.21 5 14 5C11.79 5 10 6.79 10 9C10 11.21 11.79 13 14 13Z" />
                            </svg>
                        </Link>

                        <Link class="account-icon cart" href="/cart" title="Корзина">
                            <span class="number-tag" v-show="cart.count > 0">{{ cart.count }}</span>
                            <svg width="28" height="28" viewBox="0 0 28 28" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 10V8C9 6.67392 9.52678 5.40215 10.4645 4.46447C11.4021 3.52678 12.6739 3 14 3C15.3261 3 16.5979 3.52678 17.5355 4.46447C18.4732 5.40215 19 6.67392 19 8V10H22C22.2652 10 22.5196 10.1054 22.7071 10.2929C22.8946 10.4804 23 10.7348 23 11V23C23 23.2652 22.8946 23.5196 22.7071 23.7071C22.5196 23.8946 22.2652 24 22 24H6C5.73478 24 5.48043 23.8946 5.29289 23.7071C5.10536 23.5196 5 23.2652 5 23V11C5 10.7348 5.10536 10.4804 5.29289 10.2929C5.48043 10.1054 5.73478 10 6 10H9Z" />
                            </svg>
                            <span class="ml-2 d-none d-md-inline"><Price :value="cart.subtotal" /></span>
                        </Link>
                    </div>

                    <div class="burger-icon burger-icon-white d-block d-xl-none" @click="toggleMobile">
                        <span class="burger-icon-top"></span>
                        <span class="burger-icon-mid"></span>
                        <span class="burger-icon-bottom"></span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="mobile-header-active mobile-header-wrapper-style perfect-scrollbar">
        <div class="mobile-header-wrapper-inner">
            <div class="mobile-header-content-area">
                <div class="mobile-menu-head">
                    <div class="box-head-1">
                        <Link class="logo-menu" href="/"><strong style="font-size:18px;">{{ site.name }}</strong></Link>
                        <a class="close-mobile" href="#" @click="closeMobile"><span style="font-size:24px;">✕</span></a>
                    </div>
                </div>
                <div class="mobile-menu-wrap mobile-header-border">
                    <nav>
                        <ul class="mobile-menu font-heading">
                            <li><Link href="/">Главная</Link></li>
                            <li><Link href="/catalog">Каталог</Link></li>
                            <li v-for="c in cats" :key="c.id"><Link :href="`/catalog/${c.slug}`">{{ c.name }}</Link></li>
                            <li><Link href="/about">О магазине</Link></li>
                            <li><Link href="/contact">Контакты</Link></li>
                            <li v-if="auth.user"><Link href="/account">Личный кабинет</Link></li>
                            <li v-else><Link href="/login">Войти</Link></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>
