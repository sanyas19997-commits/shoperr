<script setup>
import { onMounted, onUpdated, ref, nextTick } from 'vue';
import { router } from '@inertiajs/vue3';
import AppHeader from '../Components/AppHeader.vue';
import AppFooter from '../Components/AppFooter.vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const showNewsletter = ref(false);
const preloading = ref(true);

function dismissNewsletter() {
    showNewsletter.value = false;
    try { localStorage.setItem('billaro_newsletter_seen', '1'); } catch (e) {}
}

function onOverlayClick(e) {
    if (e.target.classList.contains('box-newsletter-overlay')) dismissNewsletter();
}

function onEsc(e) {
    if (e.key === 'Escape' && showNewsletter.value) dismissNewsletter();
}

// Re-init Kidify-зависимые виджеты после Inertia-навигации
function reinitKidify() {
    nextTick(() => {
        if (typeof window === 'undefined') return;
        // Swiper re-init обычно не нужен, потому что Vue-карусели у нас в шаблоне
        // через статические классы; но триггерим WOW.js для появления элементов.
        try { if (window.WOW) new window.WOW().init(); } catch (e) {}
        // Подсветить активный пункт меню после клика без полной перезагрузки
        document.querySelectorAll('.sticky-bar').forEach((el) => {
            el.classList.remove('stick');
        });
    });
}

onMounted(() => {
    // Прелоадер скрываем после полной загрузки
    if (document.readyState === 'complete') {
        preloading.value = false;
    } else {
        window.addEventListener('load', () => { preloading.value = false; });
        setTimeout(() => { preloading.value = false; }, 2500);
    }

    // Newsletter — показывать один раз новым пользователям
    let seen = false;
    try { seen = localStorage.getItem('billaro_newsletter_seen') === '1'; } catch (e) {}
    if (!seen) {
        setTimeout(() => { showNewsletter.value = true; }, 1500);
    }

    document.addEventListener('keydown', onEsc);

    // Flash-сообщения через тост
    router.on('finish', () => {
        reinitKidify();
        const flash = router.page?.props?.flash;
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    });

    reinitKidify();
});

onUpdated(() => reinitKidify());
</script>

<template>
    <div>
        <!-- Прелоадер -->
        <div v-if="preloading" id="preloader-active">
            <div class="preloader d-flex align-items-center justify-content-center">
                <div class="preloader-inner position-relative">
                    <div class="page-loading text-center">
                        <img class="d-inline-block" src="/kidify/assets/imgs/template/favicon.svg" alt="Billaro Store">
                        <div class="page-loading-inner"><div></div><div></div><div></div></div>
                    </div>
                </div>
            </div>
        </div>

        <AppHeader />

        <main>
            <slot />
        </main>

        <AppFooter />

        <!-- Newsletter-попап (показывается один раз новым пользователям) -->
        <div v-if="showNewsletter" class="box-popup-newsletter" style="display:block;" @click="onOverlayClick">
            <div class="box-newsletter-overlay"></div>
            <div class="box-newsletter-wrapper">
                <div class="box-newsletter-inner">
                    <a class="btn-close-popup btn-close-popup-newsletter" href="#" @click.prevent="dismissNewsletter">
                        <svg class="icon-16" fill="#111111" stroke="#111111" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </a>
                    <div class="promotion-content">
                        <div class="block-info-banner">
                            <p class="font-3xl-bold neutral-900 title-line mb-10">Зима</p>
                            <h2 class="heading-banner mb-10">
                                <span class="text-up">распродажа</span>
                                <span class="text-under">распродажа</span>
                            </h2>
                            <h4 class="heading-4 title-line-2 mb-30">Всё для вашего малыша</h4>
                            <div class="mt-10">
                                <a class="btn btn-double-border" href="/catalog" @click="dismissNewsletter">
                                    <span>Смотреть скидки</span>
                                </a>
                            </div>
                        </div>
                        <div class="promotion-label">
                            <img src="/kidify/assets/imgs/template/promotion.png" alt="Billaro Store">
                        </div>
                        <div class="promotion-banner">
                            <img src="/kidify/assets/imgs/template/promotion-banner.png" alt="Billaro Store">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
