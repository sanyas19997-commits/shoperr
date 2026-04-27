<script setup>
import { Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppHead from '../../Components/AppHead.vue';
import Price from '../../Components/Price.vue';

const props = defineProps({
    items: { type: Array, default: () => [] },
    subtotal: { type: [Number, String], default: 0 },
});

const isEmpty = computed(() => !props.items || props.items.length === 0);

function img(p, id) {
    if (p) {
        if (p.startsWith('http') || p.startsWith('/')) return p;
        return '/storage/' + p;
    }
    const idx = (Number(id || 1) % 16) + 1;
    return `/kidify/assets/imgs/page/homepage1/product${idx}.png`;
}

function changeQty(productId, value) {
    const q = Math.max(1, Math.min(99, parseInt(value) || 1));
    router.patch(`/cart/update/${productId}`, { quantity: q }, { preserveScroll: true });
}

function removeItem(productId) {
    router.delete(`/cart/remove/${productId}`, { preserveScroll: true });
}

function clearCart() {
    if (!confirm('Очистить корзину?')) return;
    router.delete('/cart/clear', { preserveScroll: true });
}
</script>

<template>
    <AppHead title="Корзина" />

    <section class="section box-section-cart">
        <div class="page-head">
            <div class="container">
                <h2 class="font-3xl-bold color-brand-3 mb-15">Корзина</h2>
                <ul class="breadcrumb">
                    <li><Link class="font-sm" href="/">Главная</Link></li>
                    <li><a class="font-sm" href="#">Корзина</a></li>
                </ul>
            </div>
        </div>

        <div class="container mt-30 mb-50">
            <div v-if="isEmpty" class="text-center py-50">
                <div style="font-size:80px;">🛒</div>
                <h3 class="font-xxl-bold neutral-900 mt-15 mb-15">Ваша корзина пуста</h3>
                <p class="font-md neutral-700 mb-25">Добавьте товары из каталога, чтобы оформить заказ</p>
                <Link href="/catalog" class="btn btn-brand-3">Перейти в каталог →</Link>
            </div>

            <div v-else class="row">
                <div class="col-lg-8 col-md-12 mb-30">
                    <div class="table-responsive" style="background:#fff;border-radius:14px;border:1px solid #eee;overflow:hidden;">
                        <table class="table table-cart align-middle mb-0">
                            <thead style="background:#FFF6EC;">
                                <tr>
                                    <th style="padding:15px;">Товар</th>
                                    <th>Цена</th>
                                    <th>Количество</th>
                                    <th>Сумма</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="row in items" :key="row.id">
                                    <td style="padding:15px;">
                                        <div class="d-flex align-items-center">
                                            <img :src="img(row.image, row.id)" :alt="row.name" style="width:80px;height:80px;object-fit:cover;border-radius:8px;margin-right:15px;background:#FFF6EC;padding:5px;">
                                            <div>
                                                <Link :href="`/product/${row.slug}`" class="font-md-bold neutral-900" style="text-decoration:none;">{{ row.name }}</Link>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="font-md neutral-900"><Price :value="row.price" /></span></td>
                                    <td>
                                        <div class="d-flex align-items-center" style="border:1px solid #ddd;border-radius:6px;display:inline-flex;">
                                            <button type="button" @click="changeQty(row.id, row.quantity - 1)" style="border:0;background:transparent;width:32px;height:36px;">−</button>
                                            <input type="number" :value="row.quantity" min="1" max="99"
                                                @change="(e) => changeQty(row.id, e.target.value)"
                                                style="width:50px;border:0;text-align:center;background:transparent;">
                                            <button type="button" @click="changeQty(row.id, row.quantity + 1)" style="border:0;background:transparent;width:32px;height:36px;">+</button>
                                        </div>
                                    </td>
                                    <td><strong class="color-brand-3 font-md-bold"><Price :value="row.price * row.quantity" /></strong></td>
                                    <td>
                                        <button type="button" @click="removeItem(row.id)" class="btn btn-link" style="color:#FF4D4F;text-decoration:none;font-size:18px;" title="Удалить">✕</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between mt-20 flex-wrap" style="gap:10px;">
                        <Link href="/catalog" class="btn btn-default">← Продолжить покупки</Link>
                        <button type="button" @click="clearCart" class="btn btn-link" style="color:#999;">Очистить корзину</button>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12">
                    <div class="box-cart-summary p-25" style="background:#FFF6EC;border-radius:14px;">
                        <h4 class="font-xl-bold neutral-900 mb-20">Сумма заказа</h4>
                        <div class="d-flex justify-content-between mb-10">
                            <span class="font-md neutral-700">Товары ({{ items.length }}):</span>
                            <strong class="font-md-bold neutral-900"><Price :value="subtotal" /></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-15">
                            <span class="font-md neutral-700">Доставка:</span>
                            <span class="font-sm neutral-500">рассчитывается на след. шаге</span>
                        </div>
                        <div class="border-top pt-15 mb-20" style="border-color:#FFCBA4 !important;">
                            <div class="d-flex justify-content-between">
                                <span class="font-lg-bold neutral-900">Итого:</span>
                                <strong class="color-brand-3" style="font-size:24px;font-weight:700;"><Price :value="subtotal" /></strong>
                            </div>
                        </div>
                        <Link href="/checkout" class="btn btn-brand-3 w-100">Оформить заказ →</Link>
                        <p class="font-xs neutral-500 mt-15 mb-0 text-center">🔒 Безопасное оформление</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
