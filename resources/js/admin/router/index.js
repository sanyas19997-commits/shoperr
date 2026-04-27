import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../stores/auth';

import LoginPage from '../pages/Login.vue';
import DashboardPage from '../pages/Dashboard.vue';
import ProductsList from '../pages/products/List.vue';
import ProductForm from '../pages/products/Form.vue';
import CategoriesPage from '../pages/categories/Index.vue';
import BrandsPage from '../pages/brands/Index.vue';
import PostsPage from '../pages/posts/Index.vue';
import OrdersList from '../pages/orders/List.vue';
import OrderDetail from '../pages/orders/Detail.vue';
import UsersList from '../pages/users/List.vue';
import UserDetail from '../pages/users/Detail.vue';
import SettingsPage from '../pages/Settings.vue';
import ProfilePage from '../pages/Profile.vue';
import LogsPage from '../pages/Logs.vue';

const routes = [
    { path: '/admin/login', name: 'login', component: LoginPage, meta: { guest: true } },
    { path: '/admin', name: 'dashboard', component: DashboardPage, meta: { auth: true, title: 'Дашборд' } },
    { path: '/admin/products', name: 'products', component: ProductsList, meta: { auth: true, title: 'Товары' } },
    { path: '/admin/products/new', name: 'product-new', component: ProductForm, meta: { auth: true, title: 'Новый товар' } },
    { path: '/admin/products/:id/edit', name: 'product-edit', component: ProductForm, meta: { auth: true, title: 'Товар' }, props: true },
    { path: '/admin/categories', name: 'categories', component: CategoriesPage, meta: { auth: true, title: 'Категории' } },
    { path: '/admin/brands', name: 'brands', component: BrandsPage, meta: { auth: true, title: 'Бренды' } },
    { path: '/admin/posts', name: 'posts', component: PostsPage, meta: { auth: true, title: 'Блог' } },
    { path: '/admin/orders', name: 'orders', component: OrdersList, meta: { auth: true, title: 'Заказы' } },
    { path: '/admin/orders/:id', name: 'order-detail', component: OrderDetail, meta: { auth: true, title: 'Заказ' }, props: true },
    { path: '/admin/users', name: 'users', component: UsersList, meta: { auth: true, title: 'Пользователи' } },
    { path: '/admin/users/:id', name: 'user-detail', component: UserDetail, meta: { auth: true, title: 'Пользователь' }, props: true },
    { path: '/admin/settings', name: 'settings', component: SettingsPage, meta: { auth: true, title: 'Настройки сайта', adminOnly: true } },
    { path: '/admin/profile', name: 'profile', component: ProfilePage, meta: { auth: true, title: 'Профиль' } },
    { path: '/admin/logs', name: 'logs', component: LogsPage, meta: { auth: true, title: 'Логи действий', adminOnly: true } },
    { path: '/admin/:pathMatch(.*)*', redirect: '/admin' },
];

export const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const auth = useAuthStore();
    if (to.meta.auth && !auth.isAuthenticated) return next({ name: 'login' });
    if (to.meta.guest && auth.isAuthenticated) return next({ name: 'dashboard' });
    if (to.meta.adminOnly && !auth.isAdmin) return next({ name: 'dashboard' });
    document.title = (to.meta.title ? to.meta.title + ' — ' : '') + 'Админ Billaro';
    next();
});
