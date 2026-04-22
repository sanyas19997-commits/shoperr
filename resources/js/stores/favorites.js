import { defineStore } from 'pinia';
import api from '../api';

export const useFavoritesStore = defineStore('favorites', {
    state: () => ({
        ids: new Set(),
        list: [],
        loading: false,
    }),
    actions: {
        has(productId) {
            return this.ids.has(productId);
        },
        async fetch() {
            this.loading = true;
            try {
                const { data } = await api.get('/favorites');
                this.list = data.data;
                this.ids = new Set(this.list.map((p) => p.id));
            } finally {
                this.loading = false;
            }
        },
        async toggle(productId) {
            const { data } = await api.post(`/favorites/${productId}/toggle`);
            if (data.is_favorite) {
                this.ids.add(productId);
            } else {
                this.ids.delete(productId);
                this.list = this.list.filter((p) => p.id !== productId);
            }
            return data.is_favorite;
        },
    },
});
