<template>
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-3 order-lg-2"><InfoSidebar /></div>
            <div class="col-lg-9 order-lg-1">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb small">
                        <li class="breadcrumb-item"><router-link :to="{ name: 'home' }">Главная</router-link></li>
                        <li class="breadcrumb-item active">О нас</li>
                    </ol>
                </nav>
                <h1 class="h2 mb-4"><i class="bi bi-info-circle text-primary me-2"></i>О компании</h1>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <p class="lead mb-3">ShopHub — это современный онлайн-магазин, собравший под одной крышей электронику, технику для дома, товары для спорта, книги и подарки.</p>
                        <p class="text-muted mb-0">Мы работаем напрямую с производителями и проверенными дистрибьюторами, поэтому держим цены ниже розничных сетей и гарантируем подлинность каждой позиции.</p>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-3 col-6" v-for="s in stats" :key="s.label">
                        <div class="card border-0 shadow-sm text-center h-100">
                            <div class="card-body">
                                <div class="display-6 fw-bold text-primary">{{ s.value }}</div>
                                <div class="small text-muted">{{ s.label }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <h2 class="h4 mt-4 mb-3">Почему выбирают нас</h2>
                <div class="row g-3 mb-4">
                    <div class="col-md-6" v-for="v in values" :key="v.title">
                        <div class="d-flex gap-3">
                            <div class="text-primary flex-shrink-0"><i :class="`bi ${v.icon} fs-3`"></i></div>
                            <div>
                                <h5 class="h6 mb-1">{{ v.title }}</h5>
                                <p class="small text-muted mb-0">{{ v.text }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <h2 class="h4 mt-4 mb-3">Реквизиты</h2>
                <div class="card border-0 shadow-sm">
                    <div class="card-body small">
                        <div class="row g-2">
                            <div class="col-md-6"><span class="text-muted">Наименование:</span> ООО «ШопХаб»</div>
                            <div class="col-md-6"><span class="text-muted">ИНН:</span> 7700000000</div>
                            <div class="col-md-6"><span class="text-muted">КПП:</span> 770000000</div>
                            <div class="col-md-6"><span class="text-muted">ОГРН:</span> 1127700000000</div>
                            <div class="col-md-12"><span class="text-muted">Юридический адрес:</span> 115054, г. Москва, ул. Примерная, д. 1, пом. 101</div>
                            <div class="col-md-6"><span class="text-muted">E-mail:</span> support@shophub.test</div>
                            <div class="col-md-6"><span class="text-muted">Телефон:</span> +7 (800) 000-00-00</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import InfoSidebar from '../components/InfoSidebar.vue';
const stats = [
    { value: '7 лет', label: 'на рынке' },
    { value: '150k+', label: 'клиентов' },
    { value: '1600+', label: 'пунктов выдачи' },
    { value: '24/7', label: 'поддержка' },
];
const values = [
    { icon: 'bi-patch-check', title: 'Подлинные товары', text: 'Работаем только с официальными дистрибьюторами. Гарантия производителя на всё.' },
    { icon: 'bi-truck', title: 'Быстрая доставка', text: 'Отправляем день в день по Москве и на следующий день в регионы.' },
    { icon: 'bi-headset', title: 'Реальная поддержка', text: 'Отвечаем в течение часа в чате, email и по телефону.' },
    { icon: 'bi-shield-lock', title: 'Безопасные платежи', text: '3-D Secure, токенизация, соответствие PCI DSS.' },
];
</script>
