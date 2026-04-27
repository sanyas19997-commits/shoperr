<script setup>
import { Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import AppHead from '../../Components/AppHead.vue';
import ProductCard from '../../Components/ProductCard.vue';

const props = defineProps({
    products: { type: Object, required: true }, // paginator
    category: { type: Object, default: null },
    categories: { type: Array, default: () => [] },
    search: { type: String, default: '' },
    sort: { type: String, default: 'newest' },
    filters: { type: Object, default: () => ({}) },
});

const q = ref(props.search);
const priceMin = ref(props.filters.price_min || '');
const priceMax = ref(props.filters.price_max || '');
const sortValue = ref(props.sort);

const title = computed(() => props.category?.name || 'Каталог товаров');
const baseUrl = computed(() => props.category ? `/catalog/${props.category.slug}` : '/catalog');

function applyFilters() {
    router.get(baseUrl.value, {
        q: q.value || undefined,
        price_min: priceMin.value || undefined,
        price_max: priceMax.value || undefined,
        sort: sortValue.value,
    }, { preserveState: true, preserveScroll: false });
}

function changeSort() {
    applyFilters();
}

function resetFilters() {
    router.get('/catalog');
}
</script>

<template>
    <AppHead :title="title" />

    <section class="section box-section-shop-page">
        <div class="page-head">
            <div class="container">
                <h2 class="font-3xl-bold color-brand-3 mb-15">{{ title }}</h2>
                <ul class="breadcrumb">
                    <li><Link class="font-sm" href="/">Главная</Link></li>
                    <li><Link class="font-sm" href="/catalog">Каталог</Link></li>
                    <li v-if="category"><a class="font-sm" href="#">{{ category.name }}</a></li>
                </ul>
            </div>
        </div>

        <div class="container mt-30">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-xl-3 col-lg-4 mb-30">
                    <div class="sidebar-shop sticky-sidebar">
                        <div class="block-filter mb-30">
                            <h5 class="font-lg-bold neutral-900 mb-15">Категории</h5>
                            <ul class="list-checkbox">
                                <li class="mb-10">
                                    <Link href="/catalog" class="font-sm" :style="{ textDecoration: 'none', color: !category ? '#FF6E30' : '#0E0E0E', fontWeight: !category ? 700 : 400 }">
                                        Все товары
                                    </Link>
                                </li>
                                <li v-for="c in categories" :key="c.id" class="mb-10">
                                    <Link :href="`/catalog/${c.slug}`" class="font-sm"
                                        :style="{ textDecoration: 'none', color: category && category.id === c.id ? '#FF6E30' : '#0E0E0E', fontWeight: category && category.id === c.id ? 700 : 400 }">
                                        {{ c.name }}
                                    </Link>
                                    <ul v-if="c.children && c.children.length" style="padding-left:15px;margin-top:5px;">
                                        <li v-for="sub in c.children" :key="sub.id" class="mb-5">
                                            <Link :href="`/catalog/${sub.slug}`" class="font-sm"
                                                :style="{ textDecoration: 'none', color: category && category.id === sub.id ? '#FF6E30' : '#666' }">
                                                — {{ sub.name }}
                                            </Link>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>

                        <form @submit.prevent="applyFilters" class="block-filter mb-30">
                            <h5 class="font-lg-bold neutral-900 mb-15">Цена, ₽</h5>
                            <div class="d-flex align-items-center mb-15" style="gap:8px;">
                                <input type="number" min="0" class="form-control form-control-sm" v-model="priceMin" placeholder="от">
                                <span>—</span>
                                <input type="number" min="0" class="form-control form-control-sm" v-model="priceMax" placeholder="до">
                            </div>
                            <button type="submit" class="btn btn-brand-3 w-100">Применить</button>
                        </form>
                    </div>
                </div>

                <!-- Products -->
                <div class="col-xl-9 col-lg-8">
                    <form @submit.prevent="applyFilters" class="box-pagination-shop d-flex justify-content-between align-items-center mb-20 flex-wrap" style="gap:10px;background:#FAFAFA;padding:15px;border-radius:8px;">
                        <div class="d-flex align-items-center" style="gap:10px;flex:1;">
                            <input type="search" class="form-control" style="max-width:280px;" v-model="q" placeholder="Поиск товаров...">
                            <button type="submit" class="btn btn-brand-3-sm">Найти</button>
                        </div>
                        <div class="d-flex align-items-center" style="gap:10px;">
                            <span class="font-sm neutral-700">Найдено: <strong>{{ products.total }}</strong></span>
                            <select v-model="sortValue" @change="changeSort" class="form-control" style="width:auto;">
                                <option value="newest">Сначала новые</option>
                                <option value="price_asc">Дешевле</option>
                                <option value="price_desc">Дороже</option>
                                <option value="name">По названию</option>
                            </select>
                        </div>
                    </form>

                    <div v-if="!products.data.length" class="text-center py-50">
                        <h4 class="neutral-700">Товары не найдены</h4>
                        <p class="font-md neutral-500 mt-10">Попробуйте изменить параметры фильтра.</p>
                        <button class="btn btn-brand-3 mt-15" @click="resetFilters">Сбросить фильтры</button>
                    </div>

                    <template v-else>
                        <div class="row">
                            <div v-for="p in products.data" :key="p.id" class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-30">
                                <ProductCard :product="p" />
                            </div>
                        </div>

                        <nav v-if="products.last_page > 1" class="mt-20">
                            <ul class="pagination" style="display:flex;gap:6px;flex-wrap:wrap;justify-content:center;list-style:none;padding:0;">
                                <li v-for="link in products.links" :key="link.label">
                                    <Link v-if="link.url" :href="link.url" preserve-scroll
                                        :class="['page-link', { active: link.active }]"
                                        :style="{ display: 'inline-block', padding: '8px 14px', borderRadius: '6px', background: link.active ? '#FF6E30' : '#FFF6EC', color: link.active ? '#fff' : '#0E0E0E', textDecoration: 'none' }"
                                        v-html="link.label"
                                    />
                                    <span v-else class="page-link disabled" v-html="link.label"
                                        style="display:inline-block;padding:8px 14px;border-radius:6px;background:#fafafa;color:#aaa;" />
                                </li>
                            </ul>
                        </nav>
                    </template>
                </div>
            </div>
        </div>
    </section>
</template>
