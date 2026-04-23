<template>
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-3 order-lg-2"><InfoSidebar /></div>
            <div class="col-lg-9 order-lg-1">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb small">
                        <li class="breadcrumb-item"><router-link :to="{ name: 'home' }">Главная</router-link></li>
                        <li class="breadcrumb-item active">Оплата</li>
                    </ol>
                </nav>
                <h1 class="h2 mb-4"><i class="bi bi-credit-card text-primary me-2"></i>Оплата</h1>

                <div class="row g-3 mb-4">
                    <div class="col-md-4" v-for="m in methods" :key="m.title">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="text-primary mb-2"><i :class="`bi ${m.icon} fs-3`"></i></div>
                                <h5 class="card-title h6">{{ m.title }}</h5>
                                <p class="card-text small text-muted mb-0">{{ m.text }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <h2 class="h4 mt-4 mb-3">Принимаемые способы</h2>
                <ul class="text-muted">
                    <li><strong>Банковская карта онлайн</strong> — Visa, Mastercard, МИР. Платёж обрабатывается провайдером, данные карты не сохраняются на наших серверах.</li>
                    <li><strong>СБП</strong> — оплата по QR-коду через приложение вашего банка.</li>
                    <li><strong>Apple Pay / Google Pay / Samsung Pay</strong> — быстрая оплата в один тап.</li>
                    <li><strong>Наличными или картой при получении</strong> — доступно для курьерской доставки и пунктов выдачи.</li>
                    <li><strong>Безналичный расчёт для юр. лиц</strong> — после подтверждения заказа выставляем счёт на e-mail.</li>
                </ul>

                <h2 class="h4 mt-4 mb-3">Безопасность платежей</h2>
                <p class="text-muted">Все онлайн-платежи защищены протоколом TLS 1.3 и проходят 3-D Secure. Мы не получаем и не храним номер вашей карты — данные идут напрямую в платёжный шлюз. Кассовый чек приходит вам на e-mail автоматически (54-ФЗ).</p>

                <div class="alert alert-warning mt-4 mb-0">
                    <strong>Возврат средств.</strong> При отмене заказа или возврате товара деньги возвращаются на ту же карту в течение 3–10 рабочих дней.
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import InfoSidebar from '../components/InfoSidebar.vue';
const methods = [
    { icon: 'bi-credit-card-2-front', title: 'Картой онлайн', text: 'Безопасная оплата через платёжный шлюз с поддержкой 3-D Secure.' },
    { icon: 'bi-qr-code', title: 'СБП', text: 'Отсканируйте QR-код в приложении банка — без комиссии и регистрации.' },
    { icon: 'bi-cash-coin', title: 'При получении', text: 'Наличными или картой курьеру / в пункте выдачи после проверки заказа.' },
];
</script>
