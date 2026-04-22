import { defineStore } from 'pinia';
import api from '../api';

export const useCartStore = defineStore('cart', {
    state: () => ({
        cart: { id: null, items: [], total: 0, count: 0 },
        loading: false,
    }),
    getters: {
        itemCount: (state) => state.cart?.count || 0,
        totalAmount: (state) => state.cart?.total || 0,
        items: (state) => state.cart?.items || [],
    },
    actions: {
        _set(data) {
            this.cart = data?.data ?? data ?? { items: [], total: 0, count: 0 };
        },
        async fetchCart() {
            const { data } = await api.get('/cart');
            this._set(data);
        },
        async addItem(productId, quantity = 1) {
            const { data } = await api.post('/cart', { product_id: productId, quantity });
            this._set(data);
        },
        async updateItem(itemId, quantity) {
            const { data } = await api.put(`/cart/items/${itemId}`, { quantity });
            this._set(data);
        },
        async removeItem(itemId) {
            const { data } = await api.delete(`/cart/items/${itemId}`);
            this._set(data);
        },
        async clear() {
            const { data } = await api.delete('/cart');
            this._set(data);
        },
    },
});
