<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ProductoInventario from '@/Components/ProductoTerminado/ProductoInventario.vue';

const props = defineProps({
    inventario: { type: Object },
});
</script>

<template>
    <Head title="Producto Terminado" />

    <AuthenticatedLayout>
        <template #header>
            Producto Terminado
        </template>
            <ProductoInventario :inventario = "inventario"/>
    </AuthenticatedLayout>
</template>
