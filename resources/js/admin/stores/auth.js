import { defineStore } from 'pinia';
import api from '../services/api';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: JSON.parse(localStorage.getItem('admin_user') || 'null'),
        token: localStorage.getItem('admin_token') || null,
    }),
    getters: {
        isAuthenticated: (s) => !!s.token,
        isAdmin: (s) => s.user?.role === 'admin' || s.user?.is_admin,
        isManager: (s) => s.user?.role === 'manager',
    },
    actions: {
        async login(email, password) {
            const { data } = await api.post('/login', { email, password });
            this.token = data.token;
            this.user = data.user;
            localStorage.setItem('admin_token', data.token);
            localStorage.setItem('admin_user', JSON.stringify(data.user));
            return data.user;
        },
        async logout() {
            try { await api.post('/logout'); } catch (e) { /* ignore */ }
            this.clear();
        },
        async fetchMe() {
            try {
                const { data } = await api.get('/me');
                this.user = data.user;
                localStorage.setItem('admin_user', JSON.stringify(data.user));
            } catch (e) { this.clear(); }
        },
        clear() {
            this.user = null;
            this.token = null;
            localStorage.removeItem('admin_token');
            localStorage.removeItem('admin_user');
        },
    },
});
