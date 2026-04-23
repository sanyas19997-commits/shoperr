<template>
    <div class="app-root">
        <AppLoader />
        <AppNavbar v-if="!isAdminRoute" />
        <main>
            <router-view />
        </main>
        <AppFooter v-if="!isAdminRoute" />
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { useRoute } from 'vue-router';
import AppNavbar from './components/AppNavbar.vue';
import AppFooter from './components/AppFooter.vue';
import AppLoader from './components/AppLoader.vue';

const route = useRoute();
const isAdminRoute = computed(() => route.path.startsWith('/admin'));
</script>
