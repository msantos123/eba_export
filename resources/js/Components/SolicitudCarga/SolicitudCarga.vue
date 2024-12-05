<script>
export default {
    name: 'SolicitudCarga'
}
</script>
<script setup>
import {defineProps} from 'vue';
import TextDisabled from '@/Components/TextDisabled.vue';
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    solicitudcarga: {
        type: Object,
    },
})

const form = useForm({
    codigo:props.solicitudcarga.codigo,
    usuario:props.solicitudcarga.nombre,
    planta_nombre:props.solicitudcarga.planta_nombre,
    fecha_creacion: new Date(props.solicitudcarga.created_at).toISOString().split('T')[0]

});

</script>
<template>
    <InputLabel value="Datos de Solicitud de Carga" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
    <div class="grid grid-cols-3 gap-4 mt-4">
        <div>
            <InputLabel for="producto_id" value="Codigo"></InputLabel>
            <TextDisabled v-model="form.codigo" disabled />
        </div>
        <div>
            <InputLabel for="producto_id" value="Solicitante"></InputLabel>
            <TextDisabled v-model="form.usuario" disabled/>
        </div>
        <div>
            <InputLabel for="producto_id" value="Estado"></InputLabel>
            <span v-if      ="solicitudcarga.estado === 0"   class="bg-green-400 px-2 py-3 rounded-md mt-2 block w-full">Enviado</span>
            <span v-else-if ="solicitudcarga.estado === 1"   class="bg-yellow-400 px-2 py-3 rounded-md mt-2 block w-full">Recibido</span>
            <span v-else-if ="solicitudcarga.estado === 2"   class="bg-green-400 px-2 py-3 rounded-md mt-2 block w-full">Terminado</span>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-1 mt-2">
        <div>
            <InputLabel for="producto_id" value="Planta de Produccion"></InputLabel>
            <TextDisabled v-model="form.planta_nombre" disabled/>
        </div>
        <div>
            <InputLabel for="producto_id" value="Fecha de Solicitud"></InputLabel>
            <TextDisabled v-model="form.fecha_creacion" disabled/>
        </div>
    </div>
</template>
