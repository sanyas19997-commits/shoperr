<script setup>
import { Link } from '@inertiajs/vue3';
import AppHead from '../../Components/AppHead.vue';

const props = defineProps({
    page: { type: Object, required: true },
});
</script>

<template>
    <AppHead :title="page.title" :description="page.meta_description || ''" />

    <section class="section box-section-page">
        <div class="page-head">
            <div class="container">
                <h2 class="font-3xl-bold color-brand-3 mb-15">{{ page.title }}</h2>
                <ul class="breadcrumb">
                    <li><Link class="font-sm" href="/">Главная</Link></li>
                    <li><a class="font-sm" href="#">{{ page.title }}</a></li>
                </ul>
            </div>
        </div>
        <div class="container mt-30 mb-50">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div style="background:#fff;border:1px solid #eee;border-radius:14px;padding:40px;">
                        <div class="font-md neutral-900" v-html="page.body"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
