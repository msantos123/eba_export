<script>
export default {
    name: 'ComporbanteIngreso'
}
</script>
<script setup>
import {defineProps} from 'vue';
import TextDisabled from '@/Components/TextDisabled.vue';
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    comprobateIngreso: { type:Object },
});

const form = useForm({
    fecha_ingreso:props.comprobateIngreso.fecha_ingreso,
    codigo_ingreso: props.comprobateIngreso.codigo_ingreso,
    cefo:props.comprobateIngreso.cefo,
    observaciones:props.comprobateIngreso.observaciones,
});

</script>
<template>
    <InputLabel value="Datos de Comprobante de Ingreso" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
        <div class="grid grid-cols-3 gap-4 mt-4">
            <div>
                <InputLabel value="Fecha de Ingreso"/>
                <TextDisabled id="fecha_inge" type="text" class="mt-2 block w-full"
                v-model="form.fecha_ingreso"  disabled/>
            </div>
            <div>
                <InputLabel value="Codigo de Ingreso"/>
                <TextDisabled id="empresa" type="text" class="mt-2 block w-full"
                v-model="form.codigo_ingreso" disabled/>
            </div>
            <div>
                <InputLabel for="conductor" value="Nro. CEFO"/>
                <TextDisabled id="conductor" type="text" class="mt-2 block w-full"
                v-model="form.cefo" disabled/>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4 mt-4">
            <div>
                <InputLabel for="vehiculo" value="Observaciones"/>
                <TextDisabled id="vehiculo" type="text" class="mt-2 block w-full"
                v-model="form.observaciones" autofocus disabled/>
            </div>
        </div>
</template>
