import { defineStore } from 'pinia';
import api from '../api';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        loading: false,
    }),
    getters: {
        isAuthenticated: (state) => !!state.user,
        isAdmin: (state) => state.user?.is_admin === true,
    },
    actions: {
        async fetchUser() {
            try {
                const { data } = await api.get('/me');
                this.user = data.user;
            } catch (e) {
                this.user = null;
            }
        },
        async login(payload) {
            const { data } = await api.post('/login', payload);
            this.user = data.user;
            return this.user;
        },
        async register(payload) {
            const { data } = await api.post('/register', payload);
            this.user = data.user;
            return this.user;
        },
        async logout() {
            await api.post('/logout');
            this.user = null;
        },
        async updateProfile(payload) {
            const { data } = await api.put('/profile', payload);
            this.user = data.data || data;
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
            this.user = data.data || data;
        },
        async deleteAvatar() {
            const { data } = await api.delete('/profile/avatar');
            this.user = data.data || data;
        },
    },
});
