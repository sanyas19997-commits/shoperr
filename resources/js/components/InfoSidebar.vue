<template>
    <div class="card border-0 shadow-sm info-sidebar">
        <div class="list-group list-group-flush small">
            <router-link v-for="l in links" :key="l.name" :to="{ name: l.name }" class="list-group-item list-group-item-action" active-class="active">
                <i :class="`bi ${l.icon} me-2`"></i>{{ l.label }}
            </router-link>
        </div>
    </div>
</template>

<style scoped>
/* position: sticky alone (without Bootstrap .sticky-top) so our z-index stays
   below the navbar dropdowns (Bootstrap dropdown-menu sits at z-index: 1000). */
.info-sidebar {
    position: sticky;
    top: 80px;
    z-index: 1;
}
</style>

<script setup>
const links = [
    { name: 'delivery', label: 'Доставка', icon: 'bi-truck' },
    { name: 'payment', label: 'Оплата', icon: 'bi-credit-card' },
    { name: 'returns', label: 'Возврат', icon: 'bi-arrow-counterclockwise' },
    { name: 'about', label: 'О нас', icon: 'bi-info-circle' },
    { name: 'contacts', label: 'Контакты', icon: 'bi-chat-dots' },
];
</script>
