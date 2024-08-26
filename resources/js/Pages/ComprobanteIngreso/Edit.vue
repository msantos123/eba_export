<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import CargaTable from '@/Components/CargaTable.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import FormConocimiento from '@/Components/FormConocimiento.vue';
import ComprobanteIngreso from '@/Components/ComprobanteIngreso.vue';

const props = defineProps({
    conocimiento: { type: Object },
    cargas: { type: Object },
    comprobateIngreso: { type: Object },
    solicitud:{ type: Object },
});

const form = useForm({
    planta_id:props.solicitud.plantas_id,
    empresa:props.conocimiento.empresa,
    codigo_conocimiento:props.conocimiento.codigo,
    id_ingreso:props.comprobateIngreso.id,
    cargas:props.cargas,
});

const submitForm = (status) => {
    form.status = status;
    form.post(route('kardexs.store'), {
    });
}
</script>

<template>
    <Head title="Crear Conocimiento" />
    <AuthenticatedLayout>
        <template #header>
            Ver Comprobante de Ingreso
        </template>
    <div class="min-w-full overflow-x-auto rounded-lg shadow">
        <div class="w-full whitespace-no-wrap">
            <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                        <ComprobanteIngreso :comprobateIngreso = "comprobateIngreso"/>
                        <br>
                        <FormConocimiento :conocimiento="conocimiento" :solicitud="solicitud" :form="form"/>
                        <br>
                        <CargaTable :cargas="cargas" :form="form"/>
                        <br>
                        <div class="-mx-3 px py-4" >
                            <div class="mx-3 py-2">
                                <Link :href="route('comprobante_ingreso.index')"
                                :class="'px-4 py-2 bg-gray-400 text-white border rounded-md font-semibold text-xs'">
                                <i class="fa-solid fa-left-long" style="color: #ffffff;"></i> Volver
                                </Link>
                            </div>
                            <div class="mx-3 py-2">
                                <PrimaryButton :disabled="form.processing"
                                @click.prevent="submitForm(1,conocimiento)"
                                class="inline-block rounded-md bg-green-600 px-4 py-2 text-white hover:bg-green-500 text-sm font-sans">
                                    <i class="fa-regular fa-clipboard fa-lg" style="color: #ffffff;"></i> Ingresar a Kardex
                                </PrimaryButton>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
