<template>
    <Head title="Dashboard" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <AuthenticatedLayout>
        <template #header>
            Inicio
        </template>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 border-b border-gray-200">
                Bienvenido
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3';
</script>
