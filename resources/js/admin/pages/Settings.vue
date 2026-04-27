<script setup>
import { onMounted, reactive, ref } from 'vue';
import { toast } from 'vue3-toastify';
import api from '../services/api';

const settings = reactive({
    site_name: '', site_description: '', logo: '',
    contact_phone: '', contact_email: '', contact_address: '',
    notification_email: '', hero_title: '', hero_subtitle: '',
    home_featured_title: '', home_newest_title: '', home_popular_title: '',
    home_deal_title: '', home_testimonials_title: '', home_instagram_title: '',
    home_categories_title: '', home_brands_title: '', home_best_sellers_title: '',
    promo_title: '', promo_text: '',
});
const loading = ref(false);

async function load() {
    const { data } = await api.get('/settings');
    Object.keys(settings).forEach(k => { if (data.settings[k] !== undefined) settings[k] = data.settings[k]; });
    Object.entries(data.settings || {}).forEach(([k, v]) => {
        if (!(k in settings)) settings[k] = v;
    });
}

async function save() {
    loading.value = true;
    try {
        await api.post('/settings', { settings });
        toast.success('Настройки сохранены');
        load();
    } catch (e) { toast.error('Ошибка'); }
    finally { loading.value = false; }
}

onMounted(load);
</script>

<template>
    <form @submit.prevent="save" class="card card-pad" style="max-width:760px;">
        <h3 style="margin-top:0;">Общие</h3>
        <div class="form-group"><label>Название сайта</label><input v-model="settings.site_name" /></div>
        <div class="form-group"><label>Описание / слоган</label><textarea v-model="settings.site_description" rows="2"></textarea></div>
        <div class="form-group"><label>Путь к логотипу (storage)</label><input v-model="settings.logo" />
            <div class="help-text">Например: settings/logo.png. Загрузить новый можно через раздел Медиа.</div>
        </div>

        <h3>Контакты</h3>
        <div class="form-row">
            <div class="form-group"><label>Телефон</label><input v-model="settings.contact_phone" /></div>
            <div class="form-group"><label>Email</label><input v-model="settings.contact_email" type="email" /></div>
        </div>
        <div class="form-group"><label>Адрес</label><input v-model="settings.contact_address" /></div>

        <h3>Email-уведомления</h3>
        <div class="form-group"><label>Email для уведомлений о новых заказах</label><input v-model="settings.notification_email" type="email" /></div>

        <h3>Главная страница — hero</h3>
        <div class="form-row">
            <div class="form-group"><label>Hero заголовок</label><input v-model="settings.hero_title" /></div>
            <div class="form-group"><label>Hero подзаголовок</label><input v-model="settings.hero_subtitle" /></div>
        </div>

        <h3>Заголовки блоков главной</h3>
        <div class="form-row">
            <div class="form-group"><label>«Рекомендуемые»</label><input v-model="settings.home_featured_title" /></div>
            <div class="form-group"><label>«Новинки»</label><input v-model="settings.home_newest_title" /></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>«Популярные»</label><input v-model="settings.home_popular_title" /></div>
            <div class="form-group"><label>«Горячие предложения»</label><input v-model="settings.home_deal_title" /></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>«Отзывы»</label><input v-model="settings.home_testimonials_title" /></div>
            <div class="form-group"><label>«Instagram»</label><input v-model="settings.home_instagram_title" /></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>«Категории»</label><input v-model="settings.home_categories_title" /></div>
            <div class="form-group"><label>«Бренды»</label><input v-model="settings.home_brands_title" /></div>
        </div>
        <div class="form-group"><label>«Хиты продаж»</label><input v-model="settings.home_best_sellers_title" /></div>

        <h3>Промо-блок</h3>
        <div class="form-group"><label>Заголовок</label><input v-model="settings.promo_title" /></div>
        <div class="form-group"><label>Текст</label><textarea v-model="settings.promo_text" rows="2"></textarea></div>

        <button class="btn btn-primary" :disabled="loading">{{ loading ? 'Сохраняем…' : 'Сохранить настройки' }}</button>
    </form>
</template>
