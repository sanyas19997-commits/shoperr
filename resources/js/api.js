import axios from 'axios';
import { useLoaderStore } from './stores/loader';

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
        return Promise.reject(error);
    }
);

export default api;
