<script setup>
import { onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { useAuthStore } from './stores/auth';
import AdminLayout from './components/AdminLayout.vue';

const auth = useAuthStore();
const route = useRoute();

onMounted(async () => {
    if (auth.isAuthenticated) await auth.fetchMe();
});
</script>

<template>
    <AdminLayout v-if="auth.isAuthenticated && route.name !== 'login'">
        <router-view />
    </AdminLayout>
    <router-view v-else />
</template>
