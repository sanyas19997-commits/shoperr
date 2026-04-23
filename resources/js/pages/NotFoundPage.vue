<template>
    <div class="container py-5 text-center">
        <div class="display-1 fw-bold text-muted">404</div>
        <p class="lead">Страница не найдена</p>
        <router-link :to="{ name: 'home' }" class="btn btn-primary">На главную</router-link>
    </div>
</template>
