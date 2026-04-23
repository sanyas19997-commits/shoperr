<template>
    <div class="container py-4">
        <div class="row g-4">
            <aside class="col-lg-3">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body text-center">
                        <div class="profile-avatar mb-2">{{ initial }}</div>
                        <div class="fw-semibold">{{ auth.user?.name }}</div>
                        <div class="small text-muted">{{ auth.user?.email }}</div>
                        <div v-if="auth.isAdmin" class="badge bg-primary mt-2">Администратор</div>
                    </div>
                </div>
                <div class="list-group shadow-sm">
                    <a v-for="t in tabs" :key="t.id" href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                       :class="{ active: activeTab === t.id }"
                       @click.prevent="activeTab = t.id">
                        <span><i :class="`bi ${t.icon} me-2`"></i>{{ t.label }}</span>
                        <span v-if="t.badge" class="badge bg-primary rounded-pill">{{ t.badge }}</span>
                    </a>
                    <router-link :to="{ name: 'orders' }" class="list-group-item list-group-item-action">
                        <i class="bi bi-list-check me-2"></i>История заказов
                    </router-link>
                    <a href="#" class="list-group-item list-group-item-action text-danger" @click.prevent="logout">
                        <i class="bi bi-box-arrow-right me-2"></i>Выйти
                    </a>
                </div>
            </aside>

            <div class="col-lg-9">
                <div v-if="activeTab === 'overview'" class="row g-3">
                    <div class="col-md-4" v-for="s in summaryCards" :key="s.label">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="small text-muted">{{ s.label }}</div>
                                <div class="fs-3 fw-bold">{{ s.value }}</div>
                                <div v-if="s.hint" class="small text-muted">{{ s.hint }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">Последние заказы</h5>
                                    <router-link :to="{ name: 'orders' }" class="btn btn-sm btn-outline-primary">Все заказы</router-link>
                                </div>
                                <div v-if="ordersLoading" class="text-center py-4 text-muted">
                                    <span class="spinner-border spinner-border-sm me-2"></span>Загрузка...
                                </div>
                                <div v-else-if="!orders.length" class="text-center py-4 text-muted">
                                    У вас пока нет заказов. <router-link :to="{ name: 'catalog' }">Перейти в каталог →</router-link>
                                </div>
                                <div v-else class="table-responsive">
                                    <table class="table align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Номер</th>
                                                <th>Дата</th>
                                                <th>Сумма</th>
                                                <th>Статус</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="o in orders.slice(0, 5)" :key="o.id">
                                                <td class="small font-monospace">{{ o.number }}</td>
                                                <td class="small text-muted">{{ formatDate(o.created_at) }}</td>
                                                <td class="fw-semibold">{{ formatMoney(o.total) }}</td>
                                                <td><span class="badge" :class="orderBadge(o.status)">{{ orderLabel(o.status) }}</span></td>
                                                <td class="text-end">
                                                    <router-link :to="{ name: 'order', params: { id: o.id } }" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-arrow-right"></i>
                                                    </router-link>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="mb-3"><i class="bi bi-person-badge me-2 text-primary"></i>Личные данные</h5>
                                <div class="small mb-1"><span class="text-muted">Имя:</span> {{ auth.user?.name || '—' }}</div>
                                <div class="small mb-1"><span class="text-muted">E-mail:</span> {{ auth.user?.email || '—' }}</div>
                                <div class="small mb-1"><span class="text-muted">Телефон:</span> {{ auth.user?.phone || '—' }}</div>
                                <div class="small mb-3"><span class="text-muted">Адрес:</span> {{ auth.user?.address || '—' }}</div>
                                <button class="btn btn-outline-primary btn-sm" @click="activeTab = 'profile'">Редактировать</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="mb-3"><i class="bi bi-shield-lock me-2 text-primary"></i>Безопасность</h5>
                                <p class="small text-muted mb-3">Регулярно меняйте пароль и не используйте одинаковый пароль на разных сайтах.</p>
                                <button class="btn btn-outline-primary btn-sm" @click="activeTab = 'password'">Сменить пароль</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else-if="activeTab === 'profile'" class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3">Личные данные</h5>
                        <form @submit.prevent="saveProfile" class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Имя</label>
                                <input v-model="profile.name" required class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">E-mail</label>
                                <input v-model="profile.email" required type="email" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Телефон</label>
                                <input v-model="profile.phone" class="form-control" placeholder="+7 (___) ___-__-__" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Адрес по умолчанию</label>
                                <input v-model="profile.address" class="form-control" placeholder="Город, улица, дом, квартира" />
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
                </div>

                <div v-else-if="activeTab === 'password'" class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3">Смена пароля</h5>
                        <form @submit.prevent="savePassword" class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Текущий пароль</label>
                                <input v-model="pass.current_password" required type="password" class="form-control" />
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Новый пароль</label>
                                <input v-model="pass.password" required type="password" class="form-control" minlength="8" />
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Повторите</label>
                                <input v-model="pass.password_confirmation" required type="password" class="form-control" minlength="8" />
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

                <div v-else-if="activeTab === 'delivery'" class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3">Адрес доставки</h5>
                        <p class="small text-muted">
                            Этот адрес будет автоматически подставляться при оформлении заказа. Для разных заказов вы сможете указать другой адрес прямо в чекауте.
                        </p>
                        <form @submit.prevent="saveProfile" class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Имя получателя</label>
                                <input v-model="profile.name" required class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Телефон</label>
                                <input v-model="profile.phone" class="form-control" placeholder="+7 (___) ___-__-__" />
                            </div>
                            <div class="col-12">
                                <label class="form-label">Адрес</label>
                                <textarea v-model="profile.address" class="form-control" rows="2" placeholder="Индекс, город, улица, дом, квартира"></textarea>
                            </div>
                            <div v-if="profileMessage" class="col-12">
                                <div class="alert" :class="profileMessage.ok ? 'alert-success' : 'alert-danger'">{{ profileMessage.text }}</div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary">Сохранить адрес</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import api from '../api';
import { useAuthStore } from '../stores/auth';

const auth = useAuthStore();
const router = useRouter();

const activeTab = ref('overview');
const profile = reactive({ name: '', email: '', phone: '', address: '' });
const pass = reactive({ current_password: '', password: '', password_confirmation: '' });
const profileMessage = ref(null);
const passMessage = ref(null);

const orders = ref([]);
const ordersLoading = ref(true);

const tabs = computed(() => [
    { id: 'overview', label: 'Обзор', icon: 'bi-grid' },
    { id: 'profile', label: 'Профиль', icon: 'bi-person' },
    { id: 'delivery', label: 'Адрес доставки', icon: 'bi-geo-alt' },
    { id: 'password', label: 'Пароль', icon: 'bi-shield-lock' },
]);

const initial = computed(() => (auth.user?.name || '?').trim().charAt(0).toUpperCase());

const summaryCards = computed(() => {
    const totalSpent = orders.value
        .filter((o) => ['shipped', 'completed'].includes(o.status))
        .reduce((s, o) => s + Number(o.total || 0), 0);
    const active = orders.value.filter((o) => ['new', 'processing', 'shipped'].includes(o.status)).length;
    return [
        { label: 'Всего заказов', value: orders.value.length, hint: 'за всё время' },
        { label: 'Активных', value: active, hint: 'в пути или в обработке' },
        { label: 'Потрачено', value: formatMoney(totalSpent), hint: 'по доставленным заказам' },
    ];
});

function formatDate(iso) {
    if (!iso) return '';
    try {
        return new Date(iso).toLocaleDateString('ru-RU', { day: '2-digit', month: 'short', year: 'numeric' });
    } catch (_) { return iso; }
}
function formatMoney(v) {
    const n = Number(v || 0);
    return new Intl.NumberFormat('ru-RU').format(Math.round(n)) + ' ₽';
}
function orderLabel(s) {
    return { new: 'Новый', processing: 'В обработке', shipped: 'Отправлен', completed: 'Завершён', cancelled: 'Отменён' }[s] || s;
}
function orderBadge(s) {
    return { new: 'bg-primary', processing: 'bg-warning text-dark', shipped: 'bg-info text-dark', completed: 'bg-success', cancelled: 'bg-danger' }[s] || 'bg-secondary';
}

onMounted(async () => {
    if (auth.user) {
        profile.name = auth.user.name || '';
        profile.email = auth.user.email || '';
        profile.phone = auth.user.phone || '';
        profile.address = auth.user.address || '';
    }
    try {
        const { data } = await api.get('/orders');
        orders.value = data.data || [];
    } catch (_) {
        orders.value = [];
    } finally {
        ordersLoading.value = false;
    }
});

async function saveProfile() {
    profileMessage.value = null;
    try {
        await auth.updateProfile(profile);
        profileMessage.value = { ok: true, text: 'Данные сохранены' };
    } catch (e) {
        profileMessage.value = { ok: false, text: e.response?.data?.message || 'Ошибка сохранения' };
    }
}
async function savePassword() {
    passMessage.value = null;
    try {
        await auth.updatePassword(pass);
        pass.current_password = pass.password = pass.password_confirmation = '';
        passMessage.value = { ok: true, text: 'Пароль обновлён' };
    } catch (e) {
        passMessage.value = { ok: false, text: e.response?.data?.message || 'Ошибка' };
    }
}
async function logout() {
    await auth.logout();
    router.push({ name: 'home' });
}
</script>

<style scoped>
.profile-avatar {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    font-weight: 700;
    color: #fff;
    background: linear-gradient(135deg, #0d6efd, #6610f2);
}
</style>
