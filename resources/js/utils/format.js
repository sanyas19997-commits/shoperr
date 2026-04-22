export function formatPrice(value) {
    const n = Number(value) || 0;
    return new Intl.NumberFormat('ru-RU', { maximumFractionDigits: 0 }).format(n);
}

export function formatDate(iso) {
    if (!iso) return '';
    try {
        return new Date(iso).toLocaleString('ru-RU', { dateStyle: 'medium', timeStyle: 'short' });
    } catch (_) {
        return String(iso);
    }
}

export function statusLabel(status) {
    const map = {
        new: 'Новый',
        processing: 'В обработке',
        shipped: 'Отправлен',
        completed: 'Завершен',
        cancelled: 'Отменен',
    };
    return map[status] || status;
}
