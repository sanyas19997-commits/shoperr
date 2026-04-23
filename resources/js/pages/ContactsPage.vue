<template>
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-3 order-lg-2"><InfoSidebar /></div>
            <div class="col-lg-9 order-lg-1">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb small">
                        <li class="breadcrumb-item"><router-link :to="{ name: 'home' }">Главная</router-link></li>
                        <li class="breadcrumb-item active">Контакты</li>
                    </ol>
                </nav>
                <h1 class="h2 mb-4"><i class="bi bi-chat-dots text-primary me-2"></i>Контакты</h1>

                <div class="row g-3 mb-5">
                    <div class="col-md-4" v-for="c in contacts" :key="c.label">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="text-primary mb-2"><i :class="`bi ${c.icon} fs-3`"></i></div>
                                <div class="small text-muted">{{ c.label }}</div>
                                <div class="fw-semibold">{{ c.value }}</div>
                                <div v-if="c.hint" class="small text-muted mt-1">{{ c.hint }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h4 mb-3">Обратная связь</h2>
                        <p class="text-muted small mb-4">Напишите нам и мы ответим на указанный e-mail в течение одного рабочего дня. Все сообщения попадают в админ-панель и обрабатываются командой поддержки.</p>

                        <div v-if="sentMessage" class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i>{{ sentMessage }}
                        </div>

                        <form v-else @submit.prevent="submit" class="row g-3" novalidate>
                            <div class="col-md-6">
                                <label class="form-label">Имя <span class="text-danger">*</span></label>
                                <input v-model="form.name" type="text" class="form-control" :class="{ 'is-invalid': errors.name }" required maxlength="191" />
                                <div class="invalid-feedback">{{ errors.name?.[0] }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">E-mail <span class="text-danger">*</span></label>
                                <input v-model="form.email" type="email" class="form-control" :class="{ 'is-invalid': errors.email }" required maxlength="191" />
                                <div class="invalid-feedback">{{ errors.email?.[0] }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Телефон</label>
                                <input v-model="form.phone" type="tel" class="form-control" :class="{ 'is-invalid': errors.phone }" maxlength="32" placeholder="+7 (___) ___-__-__" />
                                <div class="invalid-feedback">{{ errors.phone?.[0] }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Тема <span class="text-danger">*</span></label>
                                <input v-model="form.subject" type="text" class="form-control" :class="{ 'is-invalid': errors.subject }" required maxlength="191" />
                                <div class="invalid-feedback">{{ errors.subject?.[0] }}</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Сообщение <span class="text-danger">*</span></label>
                                <textarea v-model="form.message" class="form-control" :class="{ 'is-invalid': errors.message }" rows="5" required maxlength="5000"></textarea>
                                <div class="invalid-feedback">{{ errors.message?.[0] }}</div>
                                <div class="form-text">{{ (form.message || '').length }} / 5000</div>
                            </div>
                            <div class="col-12 d-flex justify-content-between align-items-center">
                                <div class="small text-muted">
                                    Нажимая «Отправить», вы соглашаетесь с обработкой персональных данных.
                                </div>
                                <button type="submit" class="btn btn-primary px-4" :disabled="submitting">
                                    <span v-if="submitting" class="spinner-border spinner-border-sm me-2"></span>
                                    Отправить
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import api from '../api';
import InfoSidebar from '../components/InfoSidebar.vue';
import { useAuthStore } from '../stores/auth';

const auth = useAuthStore();

const contacts = [
    { icon: 'bi-telephone', label: 'Телефон', value: '+7 (800) 000-00-00', hint: 'Ежедневно 8:00 – 22:00' },
    { icon: 'bi-envelope', label: 'E-mail', value: 'support@shophub.test', hint: 'Отвечаем в течение часа' },
    { icon: 'bi-geo-alt', label: 'Адрес', value: 'Москва, ул. Примерная, 1', hint: 'Пн–Пт 10:00 – 19:00' },
];

const form = reactive({
    name: auth.user?.name || '',
    email: auth.user?.email || '',
    phone: '',
    subject: '',
    message: '',
});
const errors = ref({});
const submitting = ref(false);
const sentMessage = ref('');

async function submit() {
    submitting.value = true;
    errors.value = {};
    try {
        const { data } = await api.post('/feedback', form);
        sentMessage.value = data.message || 'Спасибо, мы получили ваше сообщение.';
    } catch (e) {
        errors.value = e.response?.data?.errors || {};
        if (!Object.keys(errors.value).length) {
            errors.value = { message: [e.response?.data?.message || 'Не удалось отправить сообщение'] };
        }
    } finally {
        submitting.value = false;
    }
}
</script>
