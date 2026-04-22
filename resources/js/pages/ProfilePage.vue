<template>
    <div class="container py-4">
        <div class="row g-4">
            <aside class="col-lg-3">
                <div class="list-group">
                    <router-link :to="{ name: 'profile' }" class="list-group-item list-group-item-action">
                        <i class="bi bi-person me-2"></i>Профиль
                    </router-link>
                    <router-link :to="{ name: 'orders' }" class="list-group-item list-group-item-action">
                        <i class="bi bi-box-seam me-2"></i>Мои заказы
                    </router-link>
                    <router-link :to="{ name: 'favorites' }" class="list-group-item list-group-item-action">
                        <i class="bi bi-heart me-2"></i>Избранное
                    </router-link>
                    <a href="#" @click.prevent="logout" class="list-group-item list-group-item-action text-danger">
                        <i class="bi bi-box-arrow-right me-2"></i>Выйти
                    </a>
                </div>
            </aside>
            <div class="col-lg-9">
                <div class="card p-4 mb-4">
                    <h4 class="fw-bold mb-3">Личные данные</h4>
                    <form @submit.prevent="saveProfile" class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Имя</label>
                            <input v-model="profile.name" required class="form-control" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input v-model="profile.email" required type="email" class="form-control" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Телефон</label>
                            <input v-model="profile.phone" class="form-control" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Адрес</label>
                            <input v-model="profile.address" class="form-control" />
                        </div>
                        <div v-if="profileMessage" class="col-12">
                            <div class="alert" :class="profileMessage.ok ? 'alert-success' : 'alert-danger'">
                                {{ profileMessage.text }}
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>
                </div>
                <div class="card p-4">
                    <h4 class="fw-bold mb-3">Смена пароля</h4>
                    <form @submit.prevent="savePassword" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Текущий пароль</label>
                            <input v-model="pass.current_password" required type="password" class="form-control" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Новый пароль</label>
                            <input v-model="pass.password" required type="password" class="form-control" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Повторите</label>
                            <input v-model="pass.password_confirmation" required type="password" class="form-control" />
                        </div>
                        <div v-if="passMessage" class="col-12">
                            <div class="alert" :class="passMessage.ok ? 'alert-success' : 'alert-danger'">
                                {{ passMessage.text }}
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary">Обновить пароль</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const auth = useAuthStore();
const router = useRouter();
const profile = reactive({ name: '', email: '', phone: '', address: '' });
const pass = reactive({ current_password: '', password: '', password_confirmation: '' });
const profileMessage = ref(null);
const passMessage = ref(null);

onMounted(() => {
    if (auth.user) {
        profile.name = auth.user.name || '';
        profile.email = auth.user.email || '';
        profile.phone = auth.user.phone || '';
        profile.address = auth.user.address || '';
    }
});

async function saveProfile() {
    profileMessage.value = null;
    try {
        await auth.updateProfile(profile);
        profileMessage.value = { ok: true, text: 'Данные сохранены' };
    } catch (e) {
        profileMessage.value = { ok: false, text: e.response?.data?.message || 'Ошибка' };
    }
}
async function savePassword() {
    passMessage.value = null;
    try {
        await auth.updatePassword(pass);
        pass.current_password = pass.password = pass.password_confirmation = '';
        passMessage.value = { ok: true, text: 'Пароль обновлен' };
    } catch (e) {
        passMessage.value = { ok: false, text: e.response?.data?.message || 'Ошибка' };
    }
}
async function logout() {
    await auth.logout();
    router.push({ name: 'home' });
}
</script>
