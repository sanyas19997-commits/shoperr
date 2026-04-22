import axios from 'axios';

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

api.interceptors.request.use(async (config) => {
    const method = (config.method || 'get').toLowerCase();
    if (['post', 'put', 'patch', 'delete'].includes(method)) {
        await ensureCsrf();
    }
    return config;
});

export default api;
