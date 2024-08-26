<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import CargaTable from '@/Components/CargaTable.vue';
import SolicitudCarga from '@/Components/SolicitudCarga.vue';
import GreenButton from '@/Components/GreenButton.vue';
import BlueButton from '@/Components/BlueButton.vue';

const props = defineProps({
    solicitudcarga: {
        type:Object
    },
    cargas: {
        type: Object,
    }
})

const form = useForm({
    status:'',
    planta_id:props.solicitudcarga.planta_id,
    solicitud_id:props.solicitudcarga.id,
    estado:props.solicitudcarga.estado,
});

const submitForm = (status,solicitudcarga) => {
    form.status = status;
    form.put(route('solicitudcargas.update',solicitudcarga), {
    });
}
const CreateConocimiento = (solicitudcarga) => {
    form.get(route('conocimientos.crear',solicitudcarga), {
    });
}
</script>

<template>
    <Head title="Editar Conocimiento" />
    <AuthenticatedLayout>
        <template #header>
            Ver Solicitud Carga
        </template>
        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="px-4 py-3 flex">
                <div class="mx-1">
                    <GreenButton @click.prevent="submitForm(2,solicitudcarga)"
                    v-if ="$page.props.user.permissions.includes('approved solicitud') && props.solicitudcarga.estado == 1">
                    <i class="fa-solid fa-circle-check fa-lg" style="color: #ffffff;"></i> Aprobar Modificación </GreenButton>
                    <BlueButton @click.prevent="CreateConocimiento(solicitudcarga)"
                    v-if ="$page.props.user.permissions.includes('create conocimiento') && props.solicitudcarga.estado === 2">
                        <i class="fa-solid fa-circle-check fa-lg" style="color: #ffffff;"></i> Realizar Conocimiento de Carga </BlueButton>
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
                    <CargaTable :cargas="cargas"/>
                    <br>
                </div>
                <div class="mx-3 px py-4" >
                    <div class="mx-3 py-2">
                        <Link :href="route('solicitudcargas.index')"
                        :class="'px-4 py-2 bg-gray-400 text-white border rounded-md font-semibold text-xs'">
                        <i class="fa-solid fa-left-long" style="color: #ffffff;"></i> Volver
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
