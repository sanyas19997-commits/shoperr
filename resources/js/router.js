import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from './stores/auth';
import { useLoaderStore } from './stores/loader';

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
            { path: 'support', name: 'admin.support', component: () => import('./pages/admin/Support.vue') },
            { path: 'support/:id', name: 'admin.support.show', component: () => import('./pages/admin/SupportDetail.vue') },
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

router.beforeEach(async (to, from, next) => {
    const auth = useAuthStore();
    // Show the global progress bar while the target route's lazy chunk and
    // any in-flight guards resolve. Any stops from axios responses during
    // navigation are counter-balanced by the `afterEach` below.
    try { useLoaderStore().start(); } catch (_) {}

    // Auth is hydrated from localStorage synchronously at store creation, so
    // `isAuthenticated` is already trustworthy for the first navigation. The
    // `/me` request that confirms the session runs in parallel from app.js;
    // it will correct the state (and localStorage) if the cookie expired.
    if (to.meta.requiresAuth && !auth.isAuthenticated) {
        return next({ name: 'login', query: { redirect: to.fullPath } });
    }
    if (to.meta.requiresAdmin && !auth.isAdmin) {
        return next({ name: 'home' });
    }
    if (to.meta.guestOnly && auth.isAuthenticated) {
        // Honour `?redirect=…` from an earlier forced-login bounce so the user
        // lands on the page they actually wanted, not the homepage.
        const redirect = to.query.redirect;
        if (typeof redirect === 'string' && redirect.startsWith('/') && !redirect.startsWith('//')) {
            return next(redirect);
        }
        return next({ name: 'home' });
    }
    next();
});

router.afterEach(() => {
    try { useLoaderStore().stop(); } catch (_) {}
});

router.onError(() => {
    try { useLoaderStore().stop(); } catch (_) {}
});

export default router;
