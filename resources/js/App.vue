<template>
    <div class="app-root">
        <AppLoader />
        <AppNavbar v-if="!isAdminRoute" />
        <main>
            <router-view v-slot="{ Component }">
                <transition name="page" mode="out-in">
                    <component :is="Component" />
                </transition>
            </router-view>
        </main>
        <AppFooter v-if="!isAdminRoute" />
        <AppToasts />
        <ConfirmHost />
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { useRoute } from 'vue-router';
import AppNavbar from './components/AppNavbar.vue';
import AppFooter from './components/AppFooter.vue';
import AppLoader from './components/AppLoader.vue';
import AppToasts from './components/AppToasts.vue';
import ConfirmHost from './components/ConfirmHost.vue';

const route = useRoute();
const isAdminRoute = computed(() => route.path.startsWith('/admin'));
</script>
