<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextInput from '@/Components/TextInput.vue';
import TextDisabled from '@/Components/TextDisabled.vue';
import DetalleKardex from '@/Components/DetalleKardex.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import FormConocimiento from '@/Components/FormConocimiento.vue';

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
    codigo_producto:props.kardex.codigo_producto,
    articulo:props.kardex.articulo,
    proveedor:props.kardex.proveedor,
    ubicacion:props.kardex.ubicacion,
    unidad:props.kardex.unidad,
    lote:props.kardex.lote,
    saldo:props.kardex.saldo,
    //detallekardex
    kardex_id:props.detallekardex.kardex_id,
    tipo_movimiento:props.detallekardex.tipo_movimiento,
    empresa:props.detallekardex.empresa,
    codigo_conocimiento:props.detallekardex.codigo_conocimiento,
    ingreso_id:props.detallekardex.codigoIngreso,
    salida_id:props.detallekardex.salida_id,
    ingreso:props.detallekardex.ingreso,
    salida:props.detallekardex.saldo,
    fecha_ingreso:props.detallekardex.fechaIngreso,
});

defineEmits(['submit']);

</script>

<template>
    <Head title="Crear Conocimiento" />
    <AuthenticatedLayout>
        <template #header>
            Detalle de Kardex
        </template>
        {{ props.detallekardex }}
    <div class="min-w-full overflow-x-auto rounded-lg shadow">
        <div class="w-full whitespace-no-wrap">
            <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                    <InputLabel value="Datos de Comprobante de Ingreso" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                    <form>
                        <div class="grid grid-cols-3 gap-4 mt-4">
                            <div>
                                <InputLabel for="codigo_producto" value="Codigo de Producto"></InputLabel>
                                <TextDisabled id="codigo_producto" type="text" class="mt-2 block w-full"
                                v-model="form.codigo_producto" disabled></TextDisabled>
                            </div>
                            <div>
                                <InputLabel for="articulo" value="Articulo"></InputLabel>
                                <TextDisabled id="articulo" type="text" class="mt-2 block w-full"
                                v-model="form.articulo" disabled></TextDisabled>
                            </div>
                            <div>
                                <InputLabel for="proveedor" value="Proveedor"></InputLabel>
                                <TextDisabled id="proveedor" type="text" class="mt-2 block w-full"
                                v-model="form.proveedor" disabled></TextDisabled>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4 mt-4">
                            <div>
                                <InputLabel for="ubicacion" value="Ubicacion"></InputLabel>
                                <TextDisabled id="ubicacion" type="text" class="mt-2 block w-full"
                                v-model="form.ubicacion" disabled></TextDisabled>
                            </div>
                            <div>
                                <InputLabel for="unidad" value="Unidad"></InputLabel>
                                <TextDisabled id="unidad" type="text" class="mt-2 block w-full"
                                v-model="form.unidad" disabled></TextDisabled>
                            </div>
                            <div>
                                <InputLabel for="lote" value="Nro.Lote"></InputLabel>
                                <TextDisabled id="lote" type="text" class="mt-2 block w-full"
                                v-model="form.lote" disabled></TextDisabled>
                            </div>
                        </div>
                        <br>
                        <DetalleKardex :detallekardex="detallekardex" :kardex="kardex"/>
                        <br>
                        <div class="-mx-3 px py-4">
                            <div class="mx-3">
                                <Link :href="route('comprobante_ingreso.index')"
                                :class="'px-4 py-2 bg-gray-400 text-white border rounded-md font-semibold text-xs'">
                                <i class="fa-solid fa-left-long" style="color: #ffffff;"></i> Volver
                                </Link>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
