<template>
    <div class="card border-0 shadow-sm sticky-top" style="top: 80px;">
        <div class="list-group list-group-flush small">
            <router-link v-for="l in links" :key="l.name" :to="{ name: l.name }" class="list-group-item list-group-item-action" active-class="active">
                <i :class="`bi ${l.icon} me-2`"></i>{{ l.label }}
            </router-link>
        </div>
    </div>
</template>

<script setup>
const links = [
    { name: 'delivery', label: 'Доставка', icon: 'bi-truck' },
    { name: 'payment', label: 'Оплата', icon: 'bi-credit-card' },
    { name: 'returns', label: 'Возврат', icon: 'bi-arrow-counterclockwise' },
    { name: 'about', label: 'О нас', icon: 'bi-info-circle' },
    { name: 'contacts', label: 'Контакты', icon: 'bi-chat-dots' },
];
</script>
