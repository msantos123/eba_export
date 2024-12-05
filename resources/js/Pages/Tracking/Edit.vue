<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextInput from '@/Components/TextInput.vue';
import TextDisabled from '@/Components/TextDisabled.vue';
import CargaTable from '@/Components/CargaTable.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import FormConocimiento from '@/Components/FormConocimiento.vue';

const props = defineProps({
    conocimiento: {
        type: Object,
    },
    cargas: {
        type: Object,
    },
    comprobateIngreso: {
        type:Object,
    },
    solicitud:{
        type:Object,
    },
});

const form = useForm({
    planta_id:props.solicitud.plantas_id,
    planta:props.solicitud.plantas_nombre,

    id_ingreso:props.comprobateIngreso.id,
    codigo_ingreso: props.comprobateIngreso.codigo_ingreso,
    fecha_ingreso:props.comprobateIngreso.fecha_ingreso,
    cefo:props.comprobateIngreso.cefo,
    observaciones:props.comprobateIngreso.observaciones,

    empresa:props.conocimiento.empresa,
    conductor:props.conocimiento.conductor,
    vehiculo:props.conocimiento.vehiculo,
    propietario:props.conocimiento.propietario,
    licencia:props.conocimiento.licencia,
    placa:props.conocimiento.placa,
    celular:props.conocimiento.celular,
    conocimiento_id:props.conocimiento.id,
    codigo_conocimiento:props.conocimiento.codigo,
    cargas:props.cargas,
});

defineEmits(['submit']);

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
        {{ props.conocimiento }}
    <div class="min-w-full overflow-x-auto rounded-lg shadow">
        <div class="w-full whitespace-no-wrap">
            <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                    <InputLabel value="Datos de Comprobante de Ingreso" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                    <form @submit.prevent="$event=>form.post(route('comprobante_ingreso.store'))">
                        <div class="grid grid-cols-3 gap-4 mt-4">
                            <div>
                                <InputLabel for="empresa" value="Fecha de Ingreso"></InputLabel>
                                <TextDisabled id="fecha_inge" type="text" class="mt-2 block w-full"
                                v-model="form.fecha_ingreso" autofocus disabled
                                placeholder="Ej. Trans Huayana Kapac SRL."></TextDisabled>
                                <InputError :message="form.errors.empresa" class="mt-2"></InputError>
                            </div>
                            <div>
                                <InputLabel for="empresa" value="Codigo de Ingreso"></InputLabel>
                                <TextDisabled id="empresa" type="text" class="mt-2 block w-full"
                                v-model="form.codigo_ingreso" autofocus disabled
                                placeholder="Ej. 003-24"></TextDisabled>
                                <InputError :message="form.errors.empresa" class="mt-2"></InputError>
                            </div>
                            <div>
                                <InputLabel for="conductor" value="Nro. CEFO"></InputLabel>
                                <TextDisabled id="conductor" type="text" class="mt-2 block w-full"
                                v-model="form.cefo" autofocus disabled
                                placeholder="Ej. RIB-C2403208"></TextDisabled>
                                <InputError :message="form.errors.conductor" class="mt-2"></InputError>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-4 mt-4">
                            <div>
                                <InputLabel for="vehiculo" value="Observaciones"></InputLabel>
                                <TextDisabled id="vehiculo" type="text" class="mt-2 block w-full"
                                v-model="form.observaciones" autofocus disabled
                                placeholder="Ej. Cajas en mal estado"></TextDisabled>
                                <InputError :message="form.errors.vehiculo" class="mt-2"></InputError>
                            </div>
                        </div>
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
                    </form>
                </div>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
