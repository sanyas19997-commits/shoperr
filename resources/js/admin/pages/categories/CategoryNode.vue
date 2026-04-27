<script setup>
defineProps({ node: Object, isAdmin: Boolean });
defineEmits(['edit', 'add-child', 'remove']);
</script>

<template>
    <li>
        <div style="display:flex; gap:6px; align-items:center;">
            <span style="flex:1;">
                {{ node.name }}
                <span v-if="!node.is_active" class="badge badge-canceled" style="margin-left:8px;">скрыта</span>
            </span>
            <button class="btn btn-sm" @click="$emit('edit', node.id)">Изм.</button>
            <button class="btn btn-sm" @click="$emit('add-child', node.id)">+</button>
            <button v-if="isAdmin" class="btn btn-sm btn-danger" @click="$emit('remove', node)">×</button>
        </div>
        <ul v-if="node.children?.length" class="tree-children tree-list">
            <CategoryNode
                v-for="c in node.children"
                :key="c.id"
                :node="c"
                :is-admin="isAdmin"
                @edit="(id) => $emit('edit', id)"
                @add-child="(pid) => $emit('add-child', pid)"
                @remove="(n) => $emit('remove', n)"
            />
        </ul>
    </li>
</template>
