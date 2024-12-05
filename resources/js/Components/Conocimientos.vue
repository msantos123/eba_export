<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import TextDisabled from '@/Components/TextDisabled.vue';

const props = defineProps({
    conocimientos: { type:Object },
})

const form = useForm({
    empresa:props.conocimientos.empresa,
    conductor:props.conocimientos.conductor,
    vehiculo:props.conocimientos.vehiculo,
    propietario:props.conocimientos.propietario,
    licencia:props.conocimientos.licencia,
    placa:props.conocimientos.placa,
    celular:props.conocimientos.celular,
    estado:props.conocimientos.estado,

});
</script>

<template>
    <InputLabel value="Datos de Conocimiento de Carga" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
        <div class="grid grid-cols-4 gap-4 mt-4">
            <div>
                <InputLabel for="empresa" value="Empresa Transportista"></InputLabel>
                <TextDisabled id="empresa" type="text" class="mt-2 block w-full"
                v-model="form.empresa" disabled></TextDisabled>
            </div>
            <div>
                <InputLabel for="conductor" value="Conductor"></InputLabel>
                <TextDisabled id="conductor" type="text" class="mt-2 block w-full"
                v-model="form.conductor" disabled></TextDisabled>
            </div>
            <div>
                <InputLabel for="vehiculo" value="Vehiculo"></InputLabel>
                <TextDisabled id="vehiculo" type="text" class="mt-2 block w-full"
                v-model="form.vehiculo" disabled></TextDisabled>
            </div>
            <div>
                <InputLabel for="propietario" value="Propietario"></InputLabel>
                <TextDisabled id="propietario" type="text" class="mt-2 block w-full"
                v-model="form.propietario" disabled></TextDisabled>
            </div>
        </div>
        <div class="grid grid-cols-4 gap-4 mt-4">
            <div>
                <InputLabel for="licencia" value="Licencia"></InputLabel>
                <TextDisabled id="licencia" type="text" class="mt-2 block w-full"
                v-model="form.licencia" disabled></TextDisabled>
            </div>
            <div>
                <InputLabel for="placa" value="Placa"></InputLabel>
                <TextDisabled id="placa" type="text" class="mt-2 block w-full"
                v-model="form.placa" disabled></TextDisabled>
            </div>
            <div>
                <InputLabel for="celular" value="Celular"></InputLabel>
                <TextDisabled id="celular" type="text" class="mt-2 block w-full"
                v-model="form.celular" disabled></TextDisabled>
            </div>
            <div>
            <InputLabel for="producto_id" value="Estado"></InputLabel>
            <span v-if="form.estado === 0" class="bg-gray-300 px-2 py-3 rounded-md mt-2 block w-full">Borrador</span>
            <span v-else-if="form.estado === 1" class="bg-green-400 px-2 py-3 rounded-md mt-2 block w-full">Enviado</span>
            <span v-else-if="form.estado === 2" class="bg-blue-400 px-2 py-3 rounded-md mt-2 block w-full">Recibido</span>
        </div>
        </div>
</template>
