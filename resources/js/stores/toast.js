import { defineStore } from 'pinia';

let nextId = 1;

export const useToastStore = defineStore('toast', {
    state: () => ({
        items: [],
    }),
    actions: {
        push({ type = 'info', title = '', message = '', timeout = 4500 }) {
            const id = nextId++;
            this.items.push({ id, type, title, message });
            if (timeout > 0) {
                setTimeout(() => this.remove(id), timeout);
            }
            return id;
        },
        remove(id) {
            const i = this.items.findIndex((it) => it.id === id);
            if (i !== -1) this.items.splice(i, 1);
        },
        success(message, title = 'Готово') { return this.push({ type: 'success', title, message }); },
        error(message, title = 'Ошибка')   { return this.push({ type: 'error', title, message, timeout: 7000 }); },
        warning(message, title = 'Внимание') { return this.push({ type: 'warning', title, message }); },
        info(message, title = '') { return this.push({ type: 'info', title, message }); },
    },
});
