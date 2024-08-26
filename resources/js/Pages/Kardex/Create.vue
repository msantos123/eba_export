<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextInput from '@/Components/TextInput.vue';
import CargaTable from '@/Components/CargaTable.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import FormConocimiento from '@/Components/FormConocimiento.vue';

const props = defineProps({
    conocimiento: {
        type: Object,
    },
    cargas: {
        type: Object,
    },
    codigo: {
        type:Object,
    },
    solicitud:{
        type:Object,
    },
});

const form = useForm({
    planta_id:props.solicitud.plantas_id,
    planta:props.solicitud.plantas_nombre,
    codigo_ingreso: props.codigo,
    fecha_ingreso: new Date().toISOString().slice(0, 10),
    cefo: '',
    observaciones:'',
    empresa:props.conocimiento.empresa,
    conductor:props.conocimiento.conductor,
    vehiculo:props.conocimiento.vehiculo,
    propietario:props.conocimiento.propietario,
    licencia:props.conocimiento.licencia,
    placa:props.conocimiento.placa,
    celular:props.conocimiento.celular,
    conocimiento_id:props.conocimiento.id,
    solicitud_id:props.conocimiento.solicitud_id,
    cargas:props.cargas,
    status: '',
});

const carga = ref(Object.values(props.cargas).map(carga => [
    carga.descripcion,
    carga.lote,
    carga.calidad,
    carga.gradotipo,
    carga.cantidad,
    carga.kilosnetos,
    carga.librasnetas
]))

form.carga = carga.value;
defineEmits(['submit']);

const remove = (index) => {
    carga.value.splice(index, 1);
  };
</script>

<template>
    <Head title="Crear Conocimiento" />
    <AuthenticatedLayout>
        <template #header>
            Crear Comprobante de Ingreso
        </template>
    <div class="min-w-full overflow-x-auto rounded-lg shadow">
        <div class="w-full whitespace-no-wrap">
            <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                    <InputLabel value="Datos de Comprobante de Ingreso" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                    <form @submit.prevent="$event=>form.post(route('comprobante_ingreso.store'))">
                        <div class="grid grid-cols-3 gap-4 mt-4">
                            <div>
                                <InputLabel for="empresa" value="Fecha de Ingreso"></InputLabel>
                                <TextInput id="fecha_inge" type="text" class="mt-2 block w-full"
                                v-model="form.fecha_ingreso" autofocus required
                                placeholder="Ej. Trans Huayana Kapac SRL."></TextInput>
                                <InputError :message="form.errors.empresa" class="mt-2"></InputError>
                            </div>
                            <div>
                                <InputLabel for="empresa" value="Codigo de Ingreso"></InputLabel>
                                <TextInput id="empresa" type="text" class="mt-2 block w-full"
                                v-model="form.codigo_ingreso" autofocus required
                                placeholder="Ej. 003-24"></TextInput>
                                <InputError :message="form.errors.empresa" class="mt-2"></InputError>
                            </div>
                            <div>
                                <InputLabel for="conductor" value="Nro. CEFO"></InputLabel>
                                <TextInput id="conductor" type="text" class="mt-2 block w-full"
                                v-model="form.cefo" autofocus required
                                placeholder="Ej. RIB-C2403208"></TextInput>
                                <InputError :message="form.errors.conductor" class="mt-2"></InputError>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-4 mt-4">
                            <div>
                                <InputLabel for="vehiculo" value="Observaciones"></InputLabel>
                                <TextInput id="vehiculo" type="text" class="mt-2 block w-full"
                                v-model="form.observaciones" autofocus required
                                placeholder="Ej. Cajas en mal estado"></TextInput>
                                <InputError :message="form.errors.vehiculo" class="mt-2"></InputError>
                            </div>
                        </div>
                        <br>
                        <FormConocimiento :conocimiento="conocimiento" :solicitud="solicitud" :form="form"/>
                        <br>
                        <CargaTable :cargas="cargas" :form="form"/>
                        <br>
                        <div class="-mx-3 px py-4">
                            <div class="mx-3">
                                <PrimaryButton :disabled="form.processing">
                                <i class="fa-solid fa-save text-xs"> </i> Registrar
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
