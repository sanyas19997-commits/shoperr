import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from './stores/auth';

const routes = [
    { path: '/', name: 'home', component: () => import('./pages/HomePage.vue') },
    { path: '/catalog', name: 'catalog', component: () => import('./pages/CatalogPage.vue') },
    { path: '/catalog/:slug', name: 'category', component: () => import('./pages/CatalogPage.vue') },
    { path: '/product/:slug', name: 'product', component: () => import('./pages/ProductPage.vue') },
    { path: '/cart', name: 'cart', component: () => import('./pages/CartPage.vue') },
    { path: '/checkout', name: 'checkout', component: () => import('./pages/CheckoutPage.vue'), meta: { requiresAuth: true } },
    { path: '/login', name: 'login', component: () => import('./pages/LoginPage.vue'), meta: { guestOnly: true } },
    { path: '/register', name: 'register', component: () => import('./pages/RegisterPage.vue'), meta: { guestOnly: true } },
    { path: '/forgot-password', name: 'forgot-password', component: () => import('./pages/ForgotPasswordPage.vue'), meta: { guestOnly: true } },
    { path: '/profile', name: 'profile', component: () => import('./pages/ProfilePage.vue'), meta: { requiresAuth: true } },
    { path: '/orders', name: 'orders', component: () => import('./pages/OrdersPage.vue'), meta: { requiresAuth: true } },
    { path: '/orders/:id', name: 'order', component: () => import('./pages/OrderPage.vue'), meta: { requiresAuth: true } },
    { path: '/favorites', name: 'favorites', component: () => import('./pages/FavoritesPage.vue'), meta: { requiresAuth: true } },

    // Info pages
    { path: '/delivery', name: 'delivery', component: () => import('./pages/DeliveryPage.vue') },
    { path: '/payment', name: 'payment', component: () => import('./pages/PaymentPage.vue') },
    { path: '/returns', name: 'returns', component: () => import('./pages/ReturnsPage.vue') },
    { path: '/about', name: 'about', component: () => import('./pages/AboutPage.vue') },
    { path: '/contacts', name: 'contacts', component: () => import('./pages/ContactsPage.vue') },

    // Admin
    {
        path: '/admin',
        component: () => import('./pages/admin/AdminLayout.vue'),
        meta: { requiresAuth: true, requiresAdmin: true },
        children: [
            { path: '', name: 'admin.dashboard', component: () => import('./pages/admin/Dashboard.vue') },
            { path: 'products', name: 'admin.products', component: () => import('./pages/admin/Products.vue') },
            { path: 'products/new', name: 'admin.products.new', component: () => import('./pages/admin/ProductForm.vue') },
            { path: 'products/:id/edit', name: 'admin.products.edit', component: () => import('./pages/admin/ProductForm.vue') },
            { path: 'categories', name: 'admin.categories', component: () => import('./pages/admin/Categories.vue') },
            { path: 'orders', name: 'admin.orders', component: () => import('./pages/admin/Orders.vue') },
            { path: 'orders/:id', name: 'admin.orders.show', component: () => import('./pages/admin/OrderDetail.vue') },
            { path: 'users', name: 'admin.users', component: () => import('./pages/admin/Users.vue') },
            { path: 'banners', name: 'admin.banners', component: () => import('./pages/admin/Banners.vue') },
            { path: 'feedback', name: 'admin.feedback', component: () => import('./pages/admin/Feedback.vue') },
            { path: 'feedback/:id', name: 'admin.feedback.show', component: () => import('./pages/admin/FeedbackDetail.vue') },
        ],
    },

    { path: '/:pathMatch(.*)*', name: 'not-found', component: () => import('./pages/NotFoundPage.vue') },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior() {
        return { top: 0 };
    },
});

router.beforeEach((to, from, next) => {
    const auth = useAuthStore();
    if (to.meta.requiresAuth && !auth.isAuthenticated) {
        return next({ name: 'login', query: { redirect: to.fullPath } });
    }
    if (to.meta.requiresAdmin && !auth.isAdmin) {
        return next({ name: 'home' });
    }
    if (to.meta.guestOnly && auth.isAuthenticated) {
        return next({ name: 'home' });
    }
    next();
});

export default router;
