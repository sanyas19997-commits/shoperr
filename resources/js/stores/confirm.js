import { defineStore } from 'pinia';

export const useConfirmStore = defineStore('confirm', {
    state: () => ({
        open: false,
        title: 'Подтвердите действие',
        message: 'Вы уверены?',
        confirmLabel: 'Удалить',
        cancelLabel: 'Отмена',
        variant: 'danger',
        _resolve: null,
    }),
    actions: {
        ask({ title, message, confirmLabel = 'Удалить', cancelLabel = 'Отмена', variant = 'danger' } = {}) {
            this.title = title || 'Подтвердите действие';
            this.message = message || 'Вы уверены?';
            this.confirmLabel = confirmLabel;
            this.cancelLabel = cancelLabel;
            this.variant = variant;
            this.open = true;
            return new Promise((resolve) => { this._resolve = resolve; });
        },
        confirm() {
            this.open = false;
            if (this._resolve) this._resolve(true);
            this._resolve = null;
        },
        cancel() {
            this.open = false;
            if (this._resolve) this._resolve(false);
            this._resolve = null;
        },
    },
});
