import { defineStore } from 'pinia';
import api from '../api';

// Minimal user snapshot cached in localStorage so the route guard can
// immediately know "there's a session" on page reload — without waiting for
// /api/me to round-trip. The real data is then refreshed from the server and
// the cache is cleared if the session is actually gone.
const CACHE_KEY = 'shophub.auth.user';

function loadCachedUser() {
    try {
        const raw = localStorage.getItem(CACHE_KEY);
        if (!raw) return null;
        const u = JSON.parse(raw);
        return u && typeof u === 'object' && u.id ? u : null;
    } catch (_) {
        return null;
    }
}

function saveCachedUser(user) {
    try {
        if (user && user.id) {
            localStorage.setItem(CACHE_KEY, JSON.stringify(user));
        } else {
            localStorage.removeItem(CACHE_KEY);
        }
    } catch (_) {}
}

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: loadCachedUser(),
        loading: false,
        initialized: false,
    }),
    getters: {
        isAuthenticated: (state) => !!state.user,
        isAdmin: (state) => state.user?.is_admin === true,
    },
    actions: {
        setUser(user) {
            this.user = user || null;
            saveCachedUser(this.user);
        },
        async fetchUser() {
            try {
                const { data } = await api.get('/me', { silent: true, silenceErrors: true });
                this.setUser(data.user || null);
            } catch (_) {
                // Network / server error — keep the cached user so the user
                // isn't kicked out on a flaky connection. If the server
                // confirms with 401, fetchUser() returns {user: null} and we
                // clear cache above.
            } finally {
                this.initialized = true;
            }
        },
        async login(payload) {
            const { data } = await api.post('/login', payload);
            this.setUser(data.user);
            return this.user;
        },
        async register(payload) {
            const { data } = await api.post('/register', payload);
            this.setUser(data.user);
            return this.user;
        },
        async logout() {
            await api.post('/logout');
            this.setUser(null);
        },
        async updateProfile(payload) {
            const { data } = await api.put('/profile', payload);
            this.setUser(data.data || data);
        },
        async updatePassword(payload) {
            await api.put('/profile/password', payload);
        },
        async uploadAvatar(file) {
            const form = new FormData();
            form.append('avatar', file);
            const { data } = await api.post('/profile/avatar', form, {
                headers: { 'Content-Type': 'multipart/form-data' },
            });
            this.setUser(data.data || data);
        },
        async deleteAvatar() {
            const { data } = await api.delete('/profile/avatar');
            this.setUser(data.data || data);
        },
    },
});
