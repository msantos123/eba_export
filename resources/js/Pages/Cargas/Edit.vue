<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import GreenButton from '@/Components/GreenButton.vue';
import BlueButton from '@/Components/BlueButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Swal from 'sweetalert2';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    solicitudcarga: { type:Object },
    plantas: { type: Object },
    productos: { type: Object },
    cargas: { type: Object },
    kardexs: { type: Object },
})

const form = useForm({
    planta_id:props.solicitudcarga.planta_id,
    status:'',
    solicitud_id:'',
    carga:[],
});

const edit = (index) => {
    const selectedProducto = {
    codigo_producto: carga.value[index][0],
    nombre_producto: carga.value[index][1]
    };
    producto.value = selectedProducto;
    fecha_produccion.value = carga.value[index][2];
    descripcion.value = carga.value[index][3];
    lote.value = carga.value[index][4];
    cantidad.value = carga.value[index][5];
    carga.value.splice(index, 1);
};

const fecha_produccion = ref('');
const descripcion = ref('Cajas de Almendras');
const lote = ref('');
const producto = ref('');
const cantidad = ref('');

const carga = ref(Object.values(props.cargas).map(carga => [
    carga.codigo_producto,  //0
    carga.nombre_producto,  //1
    carga.fecha_produccion, //2
    carga.descripcion,      //3
    carga.lote,             //4
    carga.cantidad,         //5
    carga.kilosnetos,       //6
    carga.librasnetas,      //7
]))

const add = () => {
    const kilosnetos = cantidad.value * 20;
    const librasnetas = parseFloat((kilosnetos * 2.20462).toFixed(2));
    const newData = [
        producto.value.codigo_producto,
        producto.value.nombre_producto,
        fecha_produccion.value,
        descripcion.value,
        lote.value,
        cantidad.value,
        kilosnetos,
        librasnetas,
    ];
    carga.value.push(newData);
    descripcion.value = 'Cajas de Almendras';
    fecha_produccion.value = '';
    producto.value = '';
    lote.value='';
    cantidad.value = '';
    kilosnetos = kilosnetos;
    librasnetas= librasnetas;
};
form.carga = carga.value;

const submitForm = (status,solicitudcarga) => {
    form.status = status;
    form.put(route('solicitudcargas.update',solicitudcarga), {
    });
}

</script>

<template>
    <Head title="Actualizar Solicitud de Carga" />

    <AuthenticatedLayout>
        <template #header>
            Actualizar Solicitud de Carga
        </template>
    <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md" >
        <div class="px-4 py-3 flex">
                <div class="mx-1">
                    <GreenButton :disabled="form.processing" @click.prevent="submitForm(1,solicitudcarga)">
                    <i class="fa-solid fa-list-check fa-lg" style="color: #ffffff;"></i> Solicitar Aprobación </GreenButton>
                </div>
                <div class="mx-1">
                    <BlueButton :disabled="form.processing" @click.prevent="submitForm(2,solicitudcarga)">
                    <i class="fa-solid fa-file-circle-plus fa-lg" style="color: #ffffff;"></i> Aceptar Solicitud de Carga</BlueButton>
                </div>
        </div>
    </div>
    <div class="min-w-full overflow-x-auto rounded-lg shadow">
        <div class="w-full whitespace-no-wrap">
            <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                    <InputLabel value="Datos de Carga" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                    <form @submit.prevent="submitForm">
                        <div class="grid grid-cols-4 gap-4 mt-4" v-if="$page.props.auth.user.rol == 2">
                            <div>
                                <InputLabel for="planta_id" value="Planta de Producción"></InputLabel>
                                <select id="planta_id" v-model="form.planta_id" class="mt-2 block w-full rounded-md bg-gray-200 text-gray-800"  disabled>
                                    <option value="">-- Seleccione una opción --</option>
                                    <option v-for="planta in plantas" :value="planta.id">{{ planta.nombre }}</option>
                                </select>
                                <InputError :message="form.errors.planta_id" class="mt-2"></InputError>
                            </div>
                            <div>
                                <InputLabel value="Estado"></InputLabel>
                                <span v-if="solicitudcarga.estado === 0" class="bg-gray-300 px-2 py-3 rounded-md mt-2 block w-full">Borrador</span>
                                <span v-else-if="solicitudcarga.estado === 1" class="bg-blue-400 px-2 py-3 rounded-md mt-2 block w-full">Enviado</span>
                                <span v-else-if="solicitudcarga.estado === 2" class="bg-green-400 px-2 py-3 rounded-md mt-2 block w-full">Recibido</span>
                            </div>
                        </div>
                        <br>
                            <div class="grid grid-cols-5 gap-1 mt-2">
                                <div>
                                    <InputLabel for="producto_id" value="Producto"></InputLabel>
                                    <select id="planta_id" v-model="producto" class="mt-1 block w-full rounded-md">
                                        <option value="">-- Seleccione una opción --</option>
                                        <option v-for="producto in productos"
                                        :value="{codigo_producto: producto.codigo_producto, nombre_producto: producto.nombre_producto}">
                                        {{ producto.nombre_producto }}</option>
                                    </select>
                                    <InputError :message="form.errors.producto_id" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel for="descripcion" value="Fecha Producción" />
                                    <TextInput id="descripcion" v-model="fecha_produccion" type="date"/>
                                </div>
                                <div>
                                    <InputLabel for="lote" value="Lote" />
                                    <TextInput type="text" list="lote" placeholder="Ej. LOT-100 EA" v-model="lote"/>
                                    <datalist id="lote" >
                                        <option v-for="kardex in kardexs" :value="kardex.lote "> {{ kardex.plantas_nombre }}</option>
                                    </datalist>
                                </div>
                                <div>
                                    <InputLabel for="cantidad" value="Cantidad"/>
                                    <TextInput id="cantidad" v-model="cantidad" type="number" placeholder="Ej. 200" />
                                </div>
                                <div class="flex items-end">
                                    <BlueButton type="button" @click="add()"
                                    class="rounded-md px-4 py-2.5 text-white text-sm block w-full mt-1 block w-full">
                                    <i class="fa-solid fa-truck-ramp-box px" style="color: #ffffff;"></i>
                                    Agregar
                                    </BlueButton>
                                </div>
                            </div>
                            <br>
                            <table class="w-full border-collapse font-semibold uppercase">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="px-4 py-2">Codigo</th>
                                        <th class="px-4 py-2">Producto</th>
                                        <th class="px-4 py-2">Fecha Producción</th>
                                        <th class="px-4 py-2">Descripción</th>
                                        <th class="px-4 py-2">Lote</th>
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
                                    <td class="px-4 py-2"> {{ carga[index][6] }} </td>
                                    <td class="px-4 py-2"> {{ carga[index][7] }} </td>
                                    <td class="px-4 py-2">
                                        <SecondaryButton type="button" @click="edit(index, carga)">
                                            <i class="fa-solid fa-edit px" style="color: #ffffff;"></i>
                                        </SecondaryButton>
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
