<script setup>
import { Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppHead from '../../Components/AppHead.vue';
import Price from '../../Components/Price.vue';

const props = defineProps({
    user: { type: Object, required: true },
    orders: { type: Array, default: () => [] },
});

const initial = computed(() => (props.user.name || '?').slice(0, 1).toUpperCase());

const statusLabels = {
    new: 'Новый',
    processing: 'В обработке',
    shipped: 'Отправлен',
    completed: 'Завершён',
    cancelled: 'Отменён',
};

function formatDate(dateStr) {
    if (!dateStr) return '';
    const d = new Date(dateStr);
    const pad = (n) => String(n).padStart(2, '0');
    return `${pad(d.getDate())}.${pad(d.getMonth() + 1)}.${d.getFullYear()} ${pad(d.getHours())}:${pad(d.getMinutes())}`;
}

function logout() {
    router.post('/logout');
}
</script>

<template>
    <AppHead title="Личный кабинет" />

    <section class="section box-section-account">
        <div class="page-head">
            <div class="container">
                <h2 class="font-3xl-bold color-brand-3 mb-15">Личный кабинет</h2>
                <ul class="breadcrumb">
                    <li><Link class="font-sm" href="/">Главная</Link></li>
                    <li><a class="font-sm" href="#">Личный кабинет</a></li>
                </ul>
            </div>
        </div>

        <div class="container mt-30 mb-50">
            <div class="row">
                <div class="col-lg-4 col-md-12 mb-30">
                    <div style="background:#FFF6EC;border-radius:14px;padding:25px;">
                        <div class="text-center mb-20">
                            <div style="width:80px;height:80px;border-radius:50%;background:#FF6E30;display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:32px;font-weight:700;">{{ initial }}</div>
                            <h4 class="font-lg-bold neutral-900 mt-10 mb-0">{{ user.name }}</h4>
                            <p class="font-sm neutral-700 mb-0">{{ user.email }}</p>
                        </div>
                        <div class="border-top pt-15" style="border-color:#FFCBA4 !important;">
                            <p class="font-sm mb-10"><strong>Email:</strong> {{ user.email }}</p>
                            <p v-if="user.phone" class="font-sm mb-10"><strong>Телефон:</strong> {{ user.phone }}</p>
                            <p class="font-sm mb-15"><strong>Заказов:</strong> {{ orders.length }}</p>
                            <button type="button" class="btn btn-default w-100" @click="logout">Выйти из аккаунта</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-md-12 mb-30">
                    <h4 class="font-xl-bold neutral-900 mb-15">Мои заказы</h4>
                    <div v-if="!orders.length" class="text-center py-50" style="background:#fff;border:1px solid #eee;border-radius:14px;">
                        <div style="font-size:60px;">📦</div>
                        <h5 class="neutral-900 mt-15 mb-10">У вас пока нет заказов</h5>
                        <p class="neutral-700 mb-15">Самое время выбрать что-то интересное!</p>
                        <Link href="/catalog" class="btn btn-brand-3">В каталог →</Link>
                    </div>
                    <div v-else class="table-responsive" style="background:#fff;border:1px solid #eee;border-radius:14px;overflow:hidden;">
                        <table class="table align-middle mb-0">
                            <thead style="background:#FFF6EC;">
                                <tr>
                                    <th style="padding:15px;">№ заказа</th>
                                    <th>Дата</th>
                                    <th>Статус</th>
                                    <th>Сумма</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="o in orders" :key="o.id">
                                    <td style="padding:15px;"><strong class="font-md-bold neutral-900">{{ o.number }}</strong></td>
                                    <td><span class="font-sm neutral-700">{{ formatDate(o.created_at) }}</span></td>
                                    <td><span class="badge" style="background:#FFC107;color:#000;padding:5px 10px;border-radius:6px;">{{ statusLabels[o.status] || o.status }}</span></td>
                                    <td><strong class="color-brand-3"><Price :value="o.total" /></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
