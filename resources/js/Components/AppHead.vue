<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    title: { type: String, default: '' },
    description: { type: String, default: '' },
});

const page = usePage();
const fullTitle = computed(() => {
    const siteName = page.props.site?.name || 'Billaro Store';
    return props.title ? `${props.title} — ${siteName}` : `${siteName} — Интернет-магазин`;
});
const metaDesc = computed(() => props.description || page.props.site?.description || '');
</script>

<template>
    <Head :title="fullTitle">
        <meta name="description" :content="metaDesc" head-key="description" />
    </Head>
</template>
