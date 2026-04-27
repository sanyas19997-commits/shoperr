<script setup>
import { Link, usePage, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppHead from '../../Components/AppHead.vue';

const site = computed(() => usePage().props.site || {});

const form = useForm({
    name: '',
    email: '',
    phone: '',
    subject: '',
    message: '',
});

function submit() {
    form.post('/contact', {
        onSuccess: () => form.reset(),
    });
}

function phoneHref(p) { return 'tel:' + (p || '').replace(/[^0-9+]/g, ''); }
</script>

<template>
    <AppHead title="Контакты" />

    <section class="section box-section-contact">
        <div class="page-head">
            <div class="container">
                <h2 class="font-3xl-bold color-brand-3 mb-15">Контакты</h2>
                <ul class="breadcrumb">
                    <li><Link class="font-sm" href="/">Главная</Link></li>
                    <li><a class="font-sm" href="#">Контакты</a></li>
                </ul>
            </div>
        </div>

        <div class="container mt-30 mb-50">
            <div class="row">
                <div class="col-lg-5 col-md-12 mb-30">
                    <h4 class="font-xl-bold neutral-900 mb-20">Свяжитесь с нами</h4>
                    <p class="font-md neutral-700 mb-30">Мы всегда на связи и рады ответить на любые ваши вопросы.</p>

                    <div class="d-flex align-items-start mb-25">
                        <div style="background:#FFF6EC;width:50px;height:50px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-right:15px;flex-shrink:0;font-size:22px;">📞</div>
                        <div>
                            <h6 class="font-lg-bold neutral-900 mb-5">Телефон</h6>
                            <a :href="phoneHref(site.phone)" class="font-md neutral-700" style="text-decoration:none;">{{ site.phone }}</a>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-25">
                        <div style="background:#FFF6EC;width:50px;height:50px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-right:15px;flex-shrink:0;font-size:22px;">✉</div>
                        <div>
                            <h6 class="font-lg-bold neutral-900 mb-5">Email</h6>
                            <a :href="`mailto:${site.email}`" class="font-md neutral-700" style="text-decoration:none;">{{ site.email }}</a>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-25">
                        <div style="background:#FFF6EC;width:50px;height:50px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-right:15px;flex-shrink:0;font-size:22px;">📍</div>
                        <div>
                            <h6 class="font-lg-bold neutral-900 mb-5">Адрес</h6>
                            <p class="font-md neutral-700 mb-0">{{ site.address }}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-25">
                        <div style="background:#FFF6EC;width:50px;height:50px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-right:15px;flex-shrink:0;font-size:22px;">🕐</div>
                        <div>
                            <h6 class="font-lg-bold neutral-900 mb-5">Режим работы</h6>
                            <p class="font-md neutral-700 mb-0">Пн-Пт 9:00-20:00, Сб-Вс 10:00-18:00</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 col-md-12 mb-30">
                    <div style="background:#fff;border:1px solid #eee;border-radius:14px;padding:30px;">
                        <h4 class="font-xl-bold neutral-900 mb-20">Напишите нам</h4>
                        <form @submit.prevent="submit">
                            <div class="row">
                                <div class="col-md-6 mb-15">
                                    <label class="font-sm-bold mb-5">Имя <span style="color:red;">*</span></label>
                                    <input type="text" v-model="form.name" class="form-control" required>
                                    <small v-if="form.errors.name" class="text-danger">{{ form.errors.name }}</small>
                                </div>
                                <div class="col-md-6 mb-15">
                                    <label class="font-sm-bold mb-5">Email <span style="color:red;">*</span></label>
                                    <input type="email" v-model="form.email" class="form-control" required>
                                    <small v-if="form.errors.email" class="text-danger">{{ form.errors.email }}</small>
                                </div>
                                <div class="col-md-6 mb-15">
                                    <label class="font-sm-bold mb-5">Телефон</label>
                                    <input type="text" v-model="form.phone" class="form-control">
                                </div>
                                <div class="col-md-6 mb-15">
                                    <label class="font-sm-bold mb-5">Тема</label>
                                    <input type="text" v-model="form.subject" class="form-control">
                                </div>
                                <div class="col-12 mb-15">
                                    <label class="font-sm-bold mb-5">Сообщение <span style="color:red;">*</span></label>
                                    <textarea v-model="form.message" rows="5" class="form-control" required></textarea>
                                    <small v-if="form.errors.message" class="text-danger">{{ form.errors.message }}</small>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-brand-3" :disabled="form.processing">
                                {{ form.processing ? 'Отправляем...' : 'Отправить сообщение' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
