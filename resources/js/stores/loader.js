import { defineStore } from 'pinia';

export const useLoaderStore = defineStore('loader', {
    state: () => ({
        pending: 0,
    }),
    getters: {
        active: (state) => state.pending > 0,
    },
    actions: {
        start() {
            this.pending++;
        },
        stop() {
            this.pending = Math.max(0, this.pending - 1);
        },
        reset() {
            this.pending = 0;
        },
    },
});
