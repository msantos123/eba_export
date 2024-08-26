<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import WarningButton from '@/Components/WarningButton.vue';
import BlueButton from '@/Components/BlueButton.vue';

const props = defineProps({
    productos: {
        type: Object,
    },
    plantas: {
        type: Object,
    },
});

const form = useForm({
    usuario_id:'',
    planta_id:'',
    status:'',
    carga: [],
});

const descripcion = ref('Cajas de Almendras');
const producto = ref('');
const cantidad = ref('');
const carga = ref([]);

const add = () => {
    const kilosnetos = cantidad.value * 20;
    const librasnetas = parseFloat((kilosnetos * 2.20462).toFixed(2));
    const newData = [
        producto.value.codigo_producto,
        producto.value.nombre_producto,
        descripcion.value,
        cantidad.value,
        kilosnetos,
        librasnetas,
    ];
    carga.value.push(newData);
    descripcion.value = 'Cajas de Almendras';
    producto.value = '';
    cantidad.value = '';
    kilosnetos = kilosnetos;
    librasnetas= librasnetas;
};
form.carga = carga.value;
defineEmits(['submit']);

const remove = (index) => {
    carga.value.splice(index, 1);
  };

const submitForm = (status) => {
    form.status = status;
    form.post(route('solicitudcargas.store'), {
    });
}
</script>

<template>
    <Head title="Crear Conocimiento" />

    <AuthenticatedLayout>
        <template #header>
            Crear Solicitud de Carga
        </template>
    <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md" >
        <div class="px-4 py-3 flex">
            <div class="mx-1">
                <BlueButton :disabled="form.processing" @click.prevent="submitForm(0)">
                <i class="fa-solid fa-save"></i> Solicitar carga</BlueButton>
            </div>
        </div>
    </div>
    <div class="min-w-full overflow-x-auto rounded-lg shadow">
        <div class="w-full whitespace-no-wrap">
            <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                    <InputLabel value="Datos de Carga" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                    <form @submit.prevent="submitForm">
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <InputLabel for="planta_id" value="Planta de Producción"></InputLabel>
                                <select id="planta_id" v-model="form.planta_id" class="mt-2 block w-full rounded-md" required>
                                    <option value="">-- Seleccione una opción --</option>
                                    <option v-for="planta in plantas" :value="planta.id">{{ planta.nombre }}</option>
                                </select>
                                <InputError :message="form.errors.planta_id" class="mt-2"></InputError>
                            </div>
                        </div>
                        <br>
                            <div class="grid grid-cols-3 gap-1 mt-2">
                                <div>
                                    <InputLabel for="producto_id" value="Producto"></InputLabel>
                                    <select id="planta_id" v-model="producto" class="mt-1 block w-full rounded-md">
                                        <option value="">-- Seleccione una opción --</option>
                                        <option v-for="producto in productos"
                                        :value="{codigo_producto:producto.codigo_producto, nombre_producto:producto.nombre_producto}">
                                        {{ producto.nombre_producto }}</option>
                                    </select>
                                    <InputError :message="form.errors.producto_id" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel for="cantidad" value="Cantidad"/>
                                    <TextInput id="cantidad" v-model="cantidad" type="number" placeholder="Ej. 200" />
                                </div>
                                <div class="flex items-end">
                                    <PrimaryButton type="button" @click="add()"
                                    class="rounded-md bg-blue-600 px-2 py-2.5 text-white hover:bg-blue-500 text-sm block w-full mt-1 block w-full">
                                    <i class="fa-solid fa-truck-ramp-box px" style="color: #ffffff;"></i>
                                    Agregar
                                    </PrimaryButton>
                                </div>
                            </div>
                            <br>

                            <table class="w-full border-collapse font-semibold uppercase">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="px-4 py-2">Codigo</th>
                                        <th class="px-4 py-2">Tipo</th>
                                        <th class="px-4 py-2">Descripción</th>
                                        <th class="px-4 py-2">Cantidad</th>
                                        <th class="px-4 py-2">Kilos Netos</th>
                                        <th class="px-4 py-2">Libras Netas</th>
                                        <th class="px-4 py-2">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(_, index) in carga" :key="index" class="border-b">
                                    <td class="px-4 py-2"> {{ carga[index][0] }} </td>
                                    <td class="px-4 py-2"> {{ carga[index][1] }} </td>
                                    <td class="px-4 py-2"> {{ carga[index][2] }} </td>
                                    <td class="px-4 py-2"> {{ carga[index][3] }} </td>
                                    <td class="px-4 py-2"> {{ carga[index][4] }} </td>
                                    <td class="px-4 py-2"> {{ carga[index][5] }} </td>
                                    <td class="px-4 py-2">
                                        <WarningButton type="button" @click="remove(index, carga)">
                                        <i class="fa-solid fa-trash-can px" style="color: #ffffff;"></i>
                                        </WarningButton>
                                    </td>
                                    </tr>
                                </tbody>
                            </table>
                        <div class="-mx-3 px py-4" >
                            <div class="mx-3 py-2">
                                <Link :href="route('solicitudcargas.index')"
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
