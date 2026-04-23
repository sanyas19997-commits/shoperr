<template>
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-3 order-lg-2">
                <InfoSidebar />
            </div>
            <div class="col-lg-9 order-lg-1">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb small">
                        <li class="breadcrumb-item"><router-link :to="{ name: 'home' }">Главная</router-link></li>
                        <li class="breadcrumb-item active">Доставка</li>
                    </ol>
                </nav>
                <h1 class="h2 mb-4"><i class="bi bi-truck text-primary me-2"></i>Доставка</h1>

                <div class="row g-3 mb-4">
                    <div class="col-md-4" v-for="f in features" :key="f.title">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="text-primary mb-2"><i :class="`bi ${f.icon} fs-3`"></i></div>
                                <h5 class="card-title h6">{{ f.title }}</h5>
                                <p class="card-text small text-muted mb-0">{{ f.text }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <h2 class="h4 mt-4 mb-3">Варианты доставки</h2>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Способ</th>
                                <th>Срок</th>
                                <th>Стоимость</th>
                                <th>Регион</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="o in options" :key="o.name">
                                <td><strong>{{ o.name }}</strong><br><span class="text-muted small">{{ o.desc }}</span></td>
                                <td>{{ o.eta }}</td>
                                <td>{{ o.cost }}</td>
                                <td>{{ o.region }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h2 class="h4 mt-4 mb-3">Условия и ограничения</h2>
                <ul class="text-muted">
                    <li>Бесплатная доставка при заказе от 5 000 ₽ в черте Москвы и Санкт-Петербурга.</li>
                    <li>Оформление заказов после 18:00 переносится на следующий рабочий день.</li>
                    <li>Крупногабаритные товары доставляются отдельным транспортом по предварительному согласованию.</li>
                    <li>При получении курьеру или в пункте выдачи обязательно проверяйте целостность упаковки и комплектность.</li>
                </ul>

                <div class="alert alert-info mt-4 mb-0">
                    Есть вопросы по доставке? Напишите нам через <router-link :to="{ name: 'contacts' }">форму обратной связи</router-link> — ответим в течение рабочего дня.
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import InfoSidebar from '../components/InfoSidebar.vue';

const features = [
    { icon: 'bi-lightning-charge', title: 'Быстро', text: 'Доставка в день заказа по Москве и области при оформлении до 14:00.' },
    { icon: 'bi-geo-alt', title: 'Везде', text: 'Отправляем по всей России — 1600+ пунктов выдачи и курьером до двери.' },
    { icon: 'bi-shield-check', title: 'Надёжно', text: 'Все заказы застрахованы. При повреждении — возврат или замена за наш счёт.' },
];
const options = [
    { name: 'Курьер по Москве', desc: 'До двери, в удобный интервал', eta: '1–2 дня', cost: '390 ₽ (от 5 000 ₽ — бесплатно)', region: 'Москва и МО' },
    { name: 'Курьер по России', desc: 'СДЭК, DPD, Boxberry', eta: '2–7 дней', cost: 'от 450 ₽', region: 'Вся Россия' },
    { name: 'Пункт выдачи', desc: 'Самовывоз из ближайшего ПВЗ', eta: '2–5 дней', cost: 'от 190 ₽', region: 'Вся Россия' },
    { name: 'Почта России', desc: 'Посылка первого класса', eta: '5–14 дней', cost: 'от 290 ₽', region: 'Вся Россия' },
];
</script>
