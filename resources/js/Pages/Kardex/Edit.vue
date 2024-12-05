<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DetalleKardex from '@/Components/DetalleKardex.vue';
import Kardex from '@/Components/Kardex.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import GreenButton from '@/Components/GreenButton.vue';

const props = defineProps({
    kardex: {
        type: Object,
    },
    detallekardex: {
        type: Object,
    },
});

const form = useForm({
    //kardex
    id:props.kardex.id,
});

const CreateSalida = (kardex) => {
    form.get(route('comprobante_salida.createSalida',kardex.id), {
    });
}
</script>

<template>
    <Head title="Crear Conocimiento" />
    <AuthenticatedLayout>
        <template #header>
            Detalle de Kardex
        </template>
        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="px-4 py-3 flex">
                <div class="mx-1">
                    <Link :href="route('kardexs.index')"
                    class="inline-block rounded-md bg-gray-500 px-4 py-2 text-white hover:bg-gray-400 text-sm">
                    <i class="fa-solid fa-left-long" style="color: #ffffff;"></i> Volver
                    </Link>
                </div>
            </div>
        </div>
    <div class="min-w-full overflow-x-auto rounded-lg shadow">
        <div class="w-full whitespace-no-wrap">
            <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                    <Kardex :detallekardex="detallekardex" :kardex="kardex"/>
                    <br>
                    <DetalleKardex :detallekardex="detallekardex" :kardex="kardex"/>
                    <br>
                </div>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
