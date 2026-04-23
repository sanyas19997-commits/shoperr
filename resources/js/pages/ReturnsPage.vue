<template>
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-3 order-lg-2"><InfoSidebar /></div>
            <div class="col-lg-9 order-lg-1">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb small">
                        <li class="breadcrumb-item"><router-link :to="{ name: 'home' }">Главная</router-link></li>
                        <li class="breadcrumb-item active">Возврат</li>
                    </ol>
                </nav>
                <h1 class="h2 mb-4"><i class="bi bi-arrow-counterclockwise text-primary me-2"></i>Возврат и обмен</h1>

                <div class="alert alert-primary">
                    <i class="bi bi-info-circle me-2"></i>По закону «О защите прав потребителей» вы можете вернуть товар надлежащего качества в течение <strong>14 дней</strong> с момента получения, если сохранены его товарный вид, потребительские свойства, пломбы и ярлыки.
                </div>

                <h2 class="h4 mt-4 mb-3">Как оформить возврат</h2>
                <ol class="text-muted">
                    <li>Зайдите в <router-link :to="{ name: 'orders' }">Личный кабинет → Мои заказы</router-link>, выберите нужный заказ.</li>
                    <li>Нажмите «Оформить возврат» и укажите товары, которые хотите вернуть, и причину.</li>
                    <li>Отправьте товар обратно — курьером, в пункт выдачи или почтой по адресу, который укажем в письме.</li>
                    <li>После проверки (до 3 рабочих дней) вернём деньги тем же способом, которым вы оплачивали заказ.</li>
                </ol>

                <h2 class="h4 mt-4 mb-3">Сроки возврата денег</h2>
                <ul class="text-muted">
                    <li>Банковская карта — 3–10 рабочих дней (срок зависит от банка).</li>
                    <li>СБП — 1–3 рабочих дня.</li>
                    <li>Наличные при получении — возврат на карту после оформления заявки.</li>
                </ul>

                <h2 class="h4 mt-4 mb-3">Что нельзя вернуть</h2>
                <p class="text-muted">Товары из <a href="https://www.consultant.ru/document/cons_doc_LAW_7686/" target="_blank" rel="noopener">перечня непродовольственных товаров надлежащего качества, не подлежащих обмену</a> — например, средства личной гигиены, парфюмерия, нижнее бельё, товары с индивидуальными характеристиками.</p>

                <h2 class="h4 mt-4 mb-3">Брак или несоответствие</h2>
                <p class="text-muted">Если товар пришёл с дефектом, повреждён при транспортировке или не соответствует описанию — напишите нам через <router-link :to="{ name: 'contacts' }">форму обратной связи</router-link> с фотографиями. Мы бесплатно заменим товар или полностью вернём деньги, включая расходы на доставку.</p>

                <div class="alert alert-success mt-4 mb-0">
                    <strong>Гарантия 14 дней на комфорт:</strong> если товар не подошёл — меняем или возвращаем без лишних вопросов.
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import InfoSidebar from '../components/InfoSidebar.vue';
</script>
