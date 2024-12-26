<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import CargaPlanta from '@/Components/CargaPlanta.vue';
import SolicitudCarga from '@/Components/SolicitudCarga/SolicitudCarga.vue';
import GreenButton from '@/Components/GreenButton.vue';

const props = defineProps({
    solicitudcarga: { type:Object },
    cargas: { type: Object },
})

const form = useForm({
    status:'',
    planta_id:props.solicitudcarga.planta_id,
    solicitud_id:props.solicitudcarga.id,
    estado:props.solicitudcarga.estado,
});

const CreateConocimiento = (solicitudcarga) => {
    form.get(route('conocimientos.crear',solicitudcarga), {
    });
}
</script>

<template>
    <Head title="Editar Conocimiento" />
    <AuthenticatedLayout>
        <template #header>
            Ver Solicitud Carga a Planta Industrial
        </template>
        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="px-4 py-3 flex">
                <div class="mx-1" >
                    <Link :href="route('solicitudcargas.index')"
                    class="inline-block rounded-md bg-gray-500 px-4 py-2 text-white hover:bg-gray-400 text-sm">
                    <i class="fa-solid fa-left-long" style="color: #ffffff;"></i> Volver
                    </Link>
                </div>
                <div class="mx-1">
                    <GreenButton @click.prevent="CreateConocimiento(solicitudcarga)"
                    v-if ="$page.props.user.permissions.includes('Crear Conocimiento Carga') && props.solicitudcarga.estado === 1">
                        <i class="fa-solid fa-circle-check fa-lg" style="color: #ffffff;"></i> Realizar Conocimiento de Carga </GreenButton>
                </div>
            </div>
        </div>
    <div class="min-w-full overflow-x-auto rounded-lg shadow">
        <div class="w-full whitespace-no-wrap">
            <div class="border-b bg-gray-50 text-left text-xs
             tracking-wide text-gray-500">
                <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                    <br>
                    <SolicitudCarga :solicitudcarga="solicitudcarga" />
                    <br>
                    <CargaPlanta :cargas="cargas"/>
                </div>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
