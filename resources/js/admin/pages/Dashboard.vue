<script setup>
import { onMounted, ref, useTemplateRef, watch } from 'vue';
import { Chart, registerables } from 'chart.js';
import api from '../services/api';

Chart.register(...registerables);

const data = ref(null);
const loading = ref(true);
const chartCanvas = useTemplateRef('chartCanvas');
let chart = null;

function fmtMoney(n) {
    return new Intl.NumberFormat('ru-RU', { maximumFractionDigits: 0 }).format(n) + ' ₽';
}
function fmtDate(d) {
    return new Date(d).toLocaleString('ru-RU', { day: '2-digit', month: '2-digit', hour: '2-digit', minute: '2-digit' });
}

onMounted(async () => {
    const res = await api.get('/dashboard');
    data.value = res.data;
    loading.value = false;
    setTimeout(renderChart, 100);
});

function renderChart() {
    if (!chartCanvas.value || !data.value?.sales_chart) return;
    if (chart) chart.destroy();
    chart = new Chart(chartCanvas.value, {
        type: 'line',
        data: {
            labels: data.value.sales_chart.labels,
            datasets: [
                {
                    label: 'Выручка ₽',
                    data: data.value.sales_chart.revenue,
                    borderColor: '#5e3ea1',
                    backgroundColor: 'rgba(94,62,161,0.1)',
                    tension: 0.3,
                    yAxisID: 'y',
                },
                {
                    label: 'Заказы',
                    data: data.value.sales_chart.orders,
                    borderColor: '#16a34a',
                    backgroundColor: 'rgba(22,163,74,0.1)',
                    tension: 0.3,
                    yAxisID: 'y1',
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'top' } },
            scales: {
                y: { type: 'linear', position: 'left', beginAtZero: true, title: { display: true, text: '₽' } },
                y1: { type: 'linear', position: 'right', beginAtZero: true, grid: { drawOnChartArea: false }, title: { display: true, text: 'шт' } },
            },
        },
    });
}
</script>

<template>
    <div v-if="loading" class="empty">Загрузка…</div>
    <div v-else-if="data">
        <div class="metrics">
            <div class="card metric"><div class="metric-label">Заказов всего</div><div class="metric-value">{{ data.stats.orders_total }}</div><div class="metric-sub">сегодня: {{ data.stats.orders_today }} · новых: {{ data.stats.orders_new }}</div></div>
            <div class="card metric"><div class="metric-label">Выручка сегодня</div><div class="metric-value">{{ fmtMoney(data.stats.revenue_today) }}</div><div class="metric-sub">за месяц: {{ fmtMoney(data.stats.revenue_month) }}</div></div>
            <div class="card metric"><div class="metric-label">Товаров</div><div class="metric-value">{{ data.stats.products_total }}</div><div class="metric-sub">активных: {{ data.stats.products_active }} · мало на складе: {{ data.stats.products_low_stock }}</div></div>
            <div class="card metric"><div class="metric-label">Клиентов</div><div class="metric-value">{{ data.stats.users_total }}</div><div class="metric-sub">сотрудников: {{ data.stats.staff_total }}</div></div>
        </div>

        <div class="card" style="margin-bottom:24px;">
            <div class="card-head"><h3>Продажи за 14 дней</h3></div>
            <div class="card-pad" style="height: 320px;">
                <canvas ref="chartCanvas"></canvas>
            </div>
        </div>

        <div class="card">
            <div class="card-head"><h3>Последние заказы</h3><router-link class="btn btn-sm" :to="{ name: 'orders' }">Все заказы</router-link></div>
            <div class="table-wrap">
                <table class="data">
                    <thead><tr><th>№</th><th>Клиент</th><th>Сумма</th><th>Статус</th><th>Дата</th></tr></thead>
                    <tbody>
                        <tr v-for="o in data.recent_orders" :key="o.id">
                            <td><router-link :to="{ name: 'order-detail', params: { id: o.id } }">{{ o.number }}</router-link></td>
                            <td>{{ o.customer_name }}</td>
                            <td>{{ fmtMoney(o.total) }}</td>
                            <td><span class="badge" :class="`badge-${o.status}`">{{ o.status_label }}</span></td>
                            <td>{{ fmtDate(o.created_at) }}</td>
                        </tr>
                        <tr v-if="!data.recent_orders.length"><td colspan="5" class="empty">Заказов пока нет</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
