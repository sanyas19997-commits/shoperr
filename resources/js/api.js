import axios from 'axios';
import { useLoaderStore } from './stores/loader';
import { useToastStore } from './stores/toast';

const api = axios.create({
    baseURL: '/api',
    withCredentials: true,
    withXSRFToken: true,
    headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
    },
});

let csrfRequested = false;

async function ensureCsrf() {
    if (csrfRequested) return;
    try {
        await axios.get('/sanctum/csrf-cookie', { withCredentials: true });
        csrfRequested = true;
    } catch (_) {
        // ignore
    }
}

function safeLoader() {
    try {
        return useLoaderStore();
    } catch (_) {
        return null;
    }
}

function safeToast() {
    try {
        return useToastStore();
    } catch (_) {
        return null;
    }
}

function formatError(error) {
    if (!error.response) {
        return 'Нет соединения с сервером. Проверьте интернет и попробуйте ещё раз.';
    }
    const { status, data } = error.response;
    if (status === 422 && data?.errors) {
        const first = Object.values(data.errors)[0];
        return Array.isArray(first) ? first[0] : String(first);
    }
    if (status === 401) return 'Требуется вход в аккаунт';
    if (status === 403) return 'Недостаточно прав для этого действия';
    if (status === 404) return 'Ресурс не найден';
    if (status === 419) return 'Сессия истекла. Обновите страницу.';
    if (status === 429) return 'Слишком много запросов, попробуйте позже';
    if (status >= 500) return 'Ошибка сервера. Мы уже знаем и чиним.';
    return data?.message || 'Произошла ошибка';
}

api.interceptors.request.use(async (config) => {
    const method = (config.method || 'get').toLowerCase();
    if (['post', 'put', 'patch', 'delete'].includes(method)) {
        await ensureCsrf();
    }
    if (!config.silent) {
        safeLoader()?.start();
    }
    return config;
});

api.interceptors.response.use(
    (response) => {
        if (!response.config?.silent) {
            safeLoader()?.stop();
        }
        return response;
    },
    (error) => {
        if (!error.config?.silent) {
            safeLoader()?.stop();
        }
        // Auto-toast for unhandled server errors. Individual callers can set
        // { silenceErrors: true } on the request config to opt out (e.g. auth
        // flows that want to render errors inline without duplicating them).
        const status = error.response?.status;
        const silence = error.config?.silenceErrors
            || status === 401           // handled by the auth store / route guard
            || status === 422;          // forms show field-level errors inline
        if (!silence) {
            safeToast()?.error(formatError(error));
        }
        return Promise.reject(error);
    }
);

export default api;
