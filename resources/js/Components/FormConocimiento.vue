<script>
    export default {
        name: 'FormConocimiento'
    }
</script>
<script setup>
import { defineProps, ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextDisabled from '@/Components/TextDisabled.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    conocimiento: {
        type: Object,
    },
    solicitud:{
        type:Object,
    },
})

const form = useForm({
    planta_id:props.solicitud.plantas_id,
    planta:props.solicitud.plantas_nombre,
    empresa:props.conocimiento.empresa,
    conductor:props.conocimiento.conductor,
    vehiculo:props.conocimiento.vehiculo,
    propietario:props.conocimiento.propietario,
    licencia:props.conocimiento.licencia,
    placa:props.conocimiento.placa,
    celular:props.conocimiento.celular,
    conocimiento_id:props.conocimiento.id,
});
</script>
<template>
    <InputLabel value="Datos de Transporte" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
    <div class="grid grid-cols-4 gap-4 mt-4">
        <div>
            <InputLabel for="empresa" value="Planta Industrial"></InputLabel>
            <TextDisabled id="empresa" type="text" class="mt-2 block w-full"
            v-model="form.planta" autofocus disabled
            placeholder="Ej. Trans Huayana Kapac SRL."></TextDisabled>
            <InputError :message="form.errors.empresa" class="mt-2"></InputError>
        </div>
        <div>
            <InputLabel for="empresa" value="Empresa Transportista"></InputLabel>
            <TextDisabled id="empresa" type="text" class="mt-2 block w-full"
            v-model="form.empresa" autofocus disabled
            placeholder="Ej. Trans Huayana Kapac SRL."></TextDisabled>
            <InputError :message="form.errors.empresa" class="mt-2"></InputError>
        </div>
        <div>
            <InputLabel for="conductor" value="Conductor"></InputLabel>
            <TextDisabled id="conductor" type="text" class="mt-2 block w-full"
            v-model="form.conductor" autofocus disabled
            placeholder="Ej. Dionicio Perez Quispe"></TextDisabled>
            <InputError :message="form.errors.conductor" class="mt-2"></InputError>
        </div>
        <div>
            <InputLabel for="vehiculo" value="Vehiculo"></InputLabel>
            <TextDisabled id="vehiculo" type="text" class="mt-2 block w-full"
            v-model="form.vehiculo" autofocus disabled
            placeholder="Ej. Camion Tráile Volvo Blanco"></TextDisabled>
            <InputError :message="form.errors.vehiculo" class="mt-2"></InputError>
        </div>
    </div>
    <div class="grid grid-cols-4 gap-4 mt-4">
        <div>
            <InputLabel for="propietario" value="Propietario"></InputLabel>
            <TextDisabled id="propietario" type="text" class="mt-2 block w-full"
            v-model="form.propietario" autofocus disabled
            placeholder="Ej. Irenea Camacho Soliz"></TextDisabled>
            <InputError :message="form.errors.propietario" class="mt-2"></InputError>
        </div>
        <div>
            <InputLabel for="licencia" value="Licencia"></InputLabel>
            <TextDisabled id="licencia" type="text" class="mt-2 block w-full"
            v-model="form.licencia" autofocus disabled
            placeholder="Ej. 8323421 LP"></TextDisabled>
            <InputError :message="form.errors.licencia" class="mt-2"></InputError>
        </div>
        <div>
            <InputLabel for="placa" value="Placa"></InputLabel>
            <TextDisabled id="placa" type="text" class="mt-2 block w-full"
            v-model="form.placa" autofocus disabled
            placeholder="Ej. 123-PLP"></TextDisabled>
            <InputError :message="form.errors.placa" class="mt-2"></InputError>
        </div>
        <div>
            <InputLabel for="celular" value="Celular"></InputLabel>
            <TextDisabled id="celular" type="text" class="mt-2 block w-full"
            v-model="form.celular" autofocus disabled
            placeholder="Ej. 77373721"></TextDisabled>
            <InputError :message="form.errors.celular" class="mt-2"></InputError>
        </div>
    </div>
</template>

