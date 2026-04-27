<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const site = computed(() => page.props.site || {});
const auth = computed(() => page.props.auth || {});
const year = new Date().getFullYear();
</script>

<template>
    <footer class="footer">
        <div class="footer-1">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3 mb-30 wow animate__animated animate__fadeIn">
                        <h5 class="neutral-900 text-uppercase mb-30">Контакты</h5>
                        <p class="neutral-900 font-lg desc-company">Пн-Пт с 9:00 до 18:00</p>
                        <p class="neutral-900 font-lg phone-footer">{{ site.phone }}</p>
                        <p class="neutral-900 font-lg email-footer">{{ site.email }}</p>
                        <p class="neutral-900 font-lg">{{ site.address }}</p>
                    </div>
                    <div class="col-lg-9 mb-30">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-30 wow animate__animated animate__fadeIn">
                                <h5 class="neutral-900 text-uppercase mb-30">Компания</h5>
                                <ul class="menu-footer">
                                    <li><Link href="/about">О магазине</Link></li>
                                    <li><Link href="/contact">Контакты</Link></li>
                                    <li><Link href="/catalog">Каталог</Link></li>
                                    <li><Link href="/p/delivery">Доставка</Link></li>
                                </ul>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-30 wow animate__animated animate__fadeIn">
                                <h5 class="neutral-900 text-uppercase mb-30">Покупателям</h5>
                                <ul class="menu-footer">
                                    <li><Link href="/cart">Корзина</Link></li>
                                    <li v-if="auth.user"><Link href="/account">Личный кабинет</Link></li>
                                    <template v-else>
                                        <li><Link href="/login">Войти</Link></li>
                                        <li><Link href="/register">Регистрация</Link></li>
                                    </template>
                                    <li><Link href="/p/returns">Возврат товара</Link></li>
                                </ul>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-30 wow animate__animated animate__fadeIn">
                                <h5 class="neutral-900 text-uppercase mb-30">Поддержка</h5>
                                <ul class="menu-footer">
                                    <li><Link href="/p/delivery">Доставка и оплата</Link></li>
                                    <li><Link href="/p/returns">Возврат и обмен</Link></li>
                                    <li><Link href="/p/privacy">Конфиденциальность</Link></li>
                                    <li><Link href="/contact">Связаться с нами</Link></li>
                                </ul>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-30 wow animate__animated animate__fadeIn">
                                <h5 class="neutral-900 text-uppercase mb-30">Соцсети</h5>
                                <ul class="menu-footer">
                                    <li><a class="facebook" href="#">Facebook</a></li>
                                    <li><a class="twitter" href="#">Twitter</a></li>
                                    <li><a class="instagram" href="#">Instagram</a></li>
                                    <li><a class="pinterest" href="#">VKontakte</a></li>
                                    <li><a class="youtube" href="#">Telegram</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-2">
            <div class="container">
                <div class="footer-bottom">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-md-12 text-center text-lg-start mb-20 wow animate__animated animate__fadeIn">
                            <Link href="/"><strong style="font-size:20px;">{{ site.name }}</strong></Link>
                        </div>
                        <div class="col-lg-6 col-md-12 text-center mb-20 wow animate__animated animate__fadeIn">
                            <span class="body-p1 neutral-900 mr-5">© {{ year }} {{ site.name }}. Все права защищены.</span>
                        </div>
                        <div class="col-lg-3 col-md-12 text-center text-lg-end mb-20 wow animate__animated animate__fadeIn">
                            <span class="body-p1 neutral-900 mr-5">Принимаем оплату:</span>
                            <span class="body-p1 neutral-900">Visa, Mastercard, МИР</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>
