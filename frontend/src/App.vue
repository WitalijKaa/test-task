<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
    <!-- Navbar -->
    <nav class="nav" tabindex="-1" onclick="this.focus()">
        <div class="container" style="position: center;">
            <a class="pagename current" href="#">SyncPro</a>
            <a href="#">Settings</a>
            <a href="#">Log</a>
            <a href="#">License</a>
        </div>
    </nav>
    <button class="btn-close btn btn-sm">×</button>

    <RouterView></RouterView>
</template>

<style>
@import '@/assets/base.css';
</style>
