<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppHead from '../../Components/AppHead.vue';

const props = defineProps({
    page: { type: Object, default: null },
});

const site = computed(() => usePage().props.site || {});
</script>

<template>
    <AppHead title="О магазине" />

    <section class="section box-section-about">
        <div class="page-head">
            <div class="container">
                <h2 class="font-3xl-bold color-brand-3 mb-15">О магазине</h2>
                <ul class="breadcrumb">
                    <li><Link class="font-sm" href="/">Главная</Link></li>
                    <li><a class="font-sm" href="#">О магазине</a></li>
                </ul>
            </div>
        </div>

        <div class="container mt-30 mb-50">
            <div class="row">
                <div class="col-lg-6 mb-30">
                    <img src="/kidify/assets/imgs/page/about/about_1.png" alt="О нас" style="width:100%;border-radius:14px;" onerror="this.style.display='none'">
                </div>
                <div class="col-lg-6 mb-30">
                    <p class="font-xl brand-2 mb-15">О нашей компании</p>
                    <h2 class="font-3xl-bold color-brand-3 mb-20">{{ site.name }} — качество и забота</h2>
                    <div v-if="page && page.body" class="font-md neutral-900" v-html="page.body"></div>
                    <template v-else>
                        <p class="font-md neutral-700 mb-20">Мы — современный интернет-магазин с широким ассортиментом товаров. Работаем для вас с заботой и любовью к качеству. Доставляем по всей России.</p>
                        <p class="font-md neutral-700">Наша миссия — сделать качественные товары доступными каждому. Мы внимательно отбираем поставщиков, проверяем каждую партию и стремимся радовать вас низкими ценами и быстрой доставкой.</p>
                    </template>
                </div>
            </div>

            <div class="row mt-50">
                <div class="col-lg-3 col-md-6 mb-30 text-center">
                    <div style="background:#FFF6EC;width:80px;height:80px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:36px;">🚚</div>
                    <h5 class="font-lg-bold neutral-900 mt-15 mb-10">Быстрая доставка</h5>
                    <p class="font-sm neutral-700">Доставляем по всей России от 1 дня</p>
                </div>
                <div class="col-lg-3 col-md-6 mb-30 text-center">
                    <div style="background:#FFF6EC;width:80px;height:80px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:36px;">💯</div>
                    <h5 class="font-lg-bold neutral-900 mt-15 mb-10">Только качество</h5>
                    <p class="font-sm neutral-700">Сертифицированные товары от проверенных брендов</p>
                </div>
                <div class="col-lg-3 col-md-6 mb-30 text-center">
                    <div style="background:#FFF6EC;width:80px;height:80px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:36px;">💬</div>
                    <h5 class="font-lg-bold neutral-900 mt-15 mb-10">Поддержка 24/7</h5>
                    <p class="font-sm neutral-700">Ответим на любые вопросы в любое время</p>
                </div>
                <div class="col-lg-3 col-md-6 mb-30 text-center">
                    <div style="background:#FFF6EC;width:80px;height:80px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:36px;">↩️</div>
                    <h5 class="font-lg-bold neutral-900 mt-15 mb-10">Возврат 14 дней</h5>
                    <p class="font-sm neutral-700">Если товар не подошёл — вернём деньги</p>
                </div>
            </div>
        </div>
    </section>
</template>
