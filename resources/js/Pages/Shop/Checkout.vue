<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppHead from '../../Components/AppHead.vue';
import Price from '../../Components/Price.vue';

const props = defineProps({
    items: { type: Array, default: () => [] },
    subtotal: { type: [Number, String], default: 0 },
    paymentMethods: { type: Object, default: () => ({}) },
    deliveryMethods: { type: Object, default: () => ({}) },
});

const page = usePage();
const user = computed(() => page.props.auth?.user);

const form = useForm({
    customer_name: user.value?.name || '',
    customer_email: user.value?.email || '',
    customer_phone: '',
    delivery_method: Object.keys(props.deliveryMethods)[0] || '',
    payment_method: Object.keys(props.paymentMethods)[0] || '',
    city: '',
    address: '',
    comment: '',
});

function submit() {
    form.post('/checkout');
}
</script>

<template>
    <AppHead title="Оформление заказа" />

    <section class="section box-section-checkout">
        <div class="page-head">
            <div class="container">
                <h2 class="font-3xl-bold color-brand-3 mb-15">Оформление заказа</h2>
                <ul class="breadcrumb">
                    <li><Link class="font-sm" href="/">Главная</Link></li>
                    <li><Link class="font-sm" href="/cart">Корзина</Link></li>
                    <li><a class="font-sm" href="#">Оформление</a></li>
                </ul>
            </div>
        </div>

        <div class="container mt-30 mb-50">
            <form @submit.prevent="submit" class="row">
                <div class="col-lg-8 col-md-12 mb-30">
                    <div class="box-checkout-form" style="background:#fff;border:1px solid #eee;border-radius:14px;padding:30px;">
                        <h4 class="font-xl-bold neutral-900 mb-20">Контактные данные</h4>
                        <div class="row">
                            <div class="col-md-6 mb-15">
                                <label class="font-sm-bold mb-5">ФИО <span style="color:red;">*</span></label>
                                <input type="text" v-model="form.customer_name" class="form-control" required>
                                <small v-if="form.errors.customer_name" class="text-danger">{{ form.errors.customer_name }}</small>
                            </div>
                            <div class="col-md-6 mb-15">
                                <label class="font-sm-bold mb-5">Телефон <span style="color:red;">*</span></label>
                                <input type="text" v-model="form.customer_phone" class="form-control" placeholder="+7 (___) ___-__-__" required>
                                <small v-if="form.errors.customer_phone" class="text-danger">{{ form.errors.customer_phone }}</small>
                            </div>
                            <div class="col-12 mb-15">
                                <label class="font-sm-bold mb-5">Email <span style="color:red;">*</span></label>
                                <input type="email" v-model="form.customer_email" class="form-control" required>
                                <small v-if="form.errors.customer_email" class="text-danger">{{ form.errors.customer_email }}</small>
                            </div>
                        </div>

                        <h4 class="font-xl-bold neutral-900 mb-20 mt-25">Способ доставки</h4>
                        <div class="mb-15">
                            <label v-for="(label, key) in deliveryMethods" :key="key" class="d-flex align-items-center mb-10 p-15" style="border:1px solid #eee;border-radius:8px;cursor:pointer;">
                                <input type="radio" :value="key" v-model="form.delivery_method" required style="margin-right:10px;">
                                <span class="font-md neutral-900">{{ label }}</span>
                            </label>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-15">
                                <label class="font-sm-bold mb-5">Город</label>
                                <input type="text" v-model="form.city" class="form-control" placeholder="Москва">
                            </div>
                            <div class="col-md-8 mb-15">
                                <label class="font-sm-bold mb-5">Адрес</label>
                                <input type="text" v-model="form.address" class="form-control" placeholder="Улица, дом, квартира">
                            </div>
                        </div>

                        <h4 class="font-xl-bold neutral-900 mb-20 mt-25">Способ оплаты</h4>
                        <div class="mb-15">
                            <label v-for="(label, key) in paymentMethods" :key="key" class="d-flex align-items-center mb-10 p-15" style="border:1px solid #eee;border-radius:8px;cursor:pointer;">
                                <input type="radio" :value="key" v-model="form.payment_method" required style="margin-right:10px;">
                                <span class="font-md neutral-900">{{ label }}</span>
                            </label>
                        </div>

                        <div class="mb-15">
                            <label class="font-sm-bold mb-5">Комментарий к заказу</label>
                            <textarea v-model="form.comment" class="form-control" rows="3" placeholder="Например: позвонить за час до доставки"></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 mb-30">
                    <div class="box-cart-summary p-25" style="background:#FFF6EC;border-radius:14px;position:sticky;top:20px;">
                        <h4 class="font-xl-bold neutral-900 mb-20">Ваш заказ</h4>
                        <div v-for="row in items" :key="row.id" class="d-flex justify-content-between mb-10">
                            <span class="font-sm neutral-900">{{ row.name }} × {{ row.quantity }}</span>
                            <strong class="font-sm-bold neutral-900"><Price :value="row.price * row.quantity" /></strong>
                        </div>
                        <div class="border-top pt-15 mt-15" style="border-color:#FFCBA4 !important;">
                            <div class="d-flex justify-content-between mb-10">
                                <span class="font-md neutral-700">Товары:</span>
                                <strong class="font-md-bold neutral-900"><Price :value="subtotal" /></strong>
                            </div>
                        </div>
                        <div class="border-top pt-15 mt-15 mb-20" style="border-color:#FFCBA4 !important;">
                            <div class="d-flex justify-content-between">
                                <span class="font-lg-bold neutral-900">Итого:</span>
                                <strong class="color-brand-3" style="font-size:24px;font-weight:700;"><Price :value="subtotal" /></strong>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-brand-3 w-100" :disabled="form.processing">
                            {{ form.processing ? 'Оформляем...' : 'Подтвердить заказ' }}
                        </button>
                        <p class="font-xs neutral-500 mt-15 mb-0 text-center">🔒 Нажимая «Подтвердить», вы соглашаетесь с условиями оферты</p>
                    </div>
                </div>
            </form>
        </div>
    </section>
</template>
