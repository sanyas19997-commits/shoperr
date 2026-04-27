<script setup>
import { onMounted, ref } from 'vue';
import api from '../services/api';

const items = ref([]);
const meta = ref({});

async function load(page = 1) {
    const { data } = await api.get('/action-logs', { params: { page } });
    items.value = data.data;
    meta.value = data;
}

function fmtDate(d) { return new Date(d).toLocaleString('ru-RU'); }

onMounted(load);
</script>

<template>
    <div class="card">
        <div class="card-head"><h3>Логи действий</h3></div>
        <div class="table-wrap">
            <table class="data">
                <thead><tr><th>Когда</th><th>Кто</th><th>Действие</th><th>Объект</th><th>IP</th><th>Изменения</th></tr></thead>
                <tbody>
                    <tr v-for="log in items" :key="log.id">
                        <td>{{ fmtDate(log.created_at) }}</td>
                        <td>{{ log.user?.name || '—' }}</td>
                        <td><code>{{ log.action }}</code></td>
                        <td>{{ log.subject_type ? log.subject_type.split('\\').pop() + ' #' + log.subject_id : '—' }}</td>
                        <td>{{ log.ip || '—' }}</td>
                        <td><pre v-if="log.changes" style="font-size:11px; margin:0; white-space:pre-wrap;">{{ JSON.stringify(log.changes) }}</pre></td>
                    </tr>
                    <tr v-if="!items.length"><td colspan="6" class="empty">Записей нет</td></tr>
                </tbody>
            </table>
        </div>
        <div class="pager" v-if="meta.last_page > 1">
            <button class="page" @click="load(meta.current_page - 1)" :disabled="meta.current_page === 1">←</button>
            <span class="page is-active">{{ meta.current_page }} / {{ meta.last_page }}</span>
            <button class="page" @click="load(meta.current_page + 1)" :disabled="meta.current_page === meta.last_page">→</button>
        </div>
    </div>
</template>
