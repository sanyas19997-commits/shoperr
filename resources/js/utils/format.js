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

// Alias kept for clarity when a caller specifically wants date + time.
// (formatDate already includes both — formatDateTime makes intent explicit
// at call sites in chat/support views.)
export const formatDateTime = formatDate;

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
