<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Swal from 'sweetalert2';
import TextDisabled from '@/Components/TextDisabled.vue';
import BorradorButton from '@/Components/BorradorButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';


const props = defineProps({
    solicitudcarga: {
        type:Object
    },
    plantas: {
        type: Object,
    },
    productos: {
        type: Object,
    },
    cargas: {
        type: Object,
    }
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
    descripcion.value = carga.value[index][2];
    lote.value = carga.value[index][3];
    cantidad.value = carga.value[index][4];
    carga.value.splice(index, 1);
};

const descripcion = ref('Cajas de Almendras');
const lote = ref('');
const producto = ref('');
const cantidad = ref('');

const carga = ref(Object.values(props.cargas).map(carga => [
    carga.codigo_producto,
    carga.nombre_producto,
    carga.descripcion,
    carga.lote,
    carga.cantidad,
    carga.kilosnetos,
    carga.librasnetas,
]))

const add = () => {
    const kilosnetos = cantidad.value * 20;
    const librasnetas = parseFloat((kilosnetos * 2.20462).toFixed(2));
    const newData = [
        producto.value.codigo_producto,
        producto.value.nombre_producto,
        descripcion.value,
        lote.value,
        cantidad.value,
        kilosnetos,
        librasnetas,
    ];
    carga.value.push(newData);
    descripcion.value = 'Cajas de Almendras';
    producto.value = '';
    lote.value='';
    cantidad.value = '';
    kilosnetos = kilosnetos;
    librasnetas= librasnetas;
};
form.carga = carga.value;
defineEmits(['submit']);

const submitForm = (status,solicitudcarga) => {
    form.status = status;
    form.put(route('solicitudcargas.update',solicitudcarga), {
    });
}

const createConocimiento = (solicitudcarga) =>{
    const alerta = Swal.mixin({
        buttonsStyling:true,
    });
    alerta.fire({
        title:'Esta seguro que desea realizar el Conocimiento de Carga?',
        icon: 'question', showCancelButton:true,
        confirmButtonText:'<i class="fa-solid fa-check"></i> Si.',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar.',
    }).then((result)=>{
        if(result.isConfirmed){
            form.get(route('conocimientos.show',solicitudcarga),{
                onSuccess: () => {ok('Conocimiento de Carga')}
            });
        }
    });
}
</script>

<template>
    <Head title="Editar Conocimiento" />

    <AuthenticatedLayout>
        <template #header>
            Actualizar Solicitud de Carga
        </template>
    <div class="min-w-full overflow-x-auto rounded-lg shadow">
        <div class="w-full whitespace-no-wrap">
            <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                    <InputLabel value="Datos de Carga" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                    <form @submit.prevent="submitForm">
                        <div class="grid grid-cols-2 gap-4 mt-4" v-if="$page.props.auth.user.rol == 2">
                            <div>
                                <InputLabel for="planta_id" value="Planta de Producción"></InputLabel>
                                <select id="planta_id" v-model="form.planta_id" class="mt-2 block w-full rounded-md"  disabled>
                                    <option value="">-- Seleccione una opción --</option>
                                    <option v-for="planta in plantas" :value="planta.id">{{ planta.nombre }}</option>
                                </select>
                                <InputError :message="form.errors.planta_id" class="mt-2"></InputError>
                            </div>
                        </div>
                        <br>
                            <div class="grid grid-cols-5 gap-1 mt-2">
                                <div>
                                    <InputLabel for="descripcion" value="Descripcion" />
                                    <TextDisabled id="descripcion" v-model="descripcion" type="text" disabled/>
                                </div>
                                <div>
                                    <InputLabel for="lote" value="Lote" />
                                    <TextInput id="lote" v-model="lote" type="text" placeholder="Ej. LOT-100 (EI)"/>
                                </div>
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
                                    <InputLabel for="cantidad" value="Cantidad"/>
                                    <TextInput id="cantidad" v-model="cantidad" type="number" placeholder="Ej. 200" />
                                </div>
                                <div class="flex items-end">
                                    <button type="button" @click="add()"
                                    class="rounded-md bg-blue-600 px-4 py-2.5 text-white hover:bg-blue-500 text-sm block w-full mt-1 block w-full">
                                    <i class="fa-solid fa-truck-ramp-box px" style="color: #ffffff;"></i>
                                    Agregar
                                    </button>
                                </div>
                            </div>
                            <br>
                            <table class="w-full border-collapse font-semibold uppercase">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="px-4 py-2">Codigo</th>
                                        <th class="px-4 py-2">Tipo</th>
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
                                    <td class="px-4 py-2">
                                        <SecondaryButton type="button" @click="edit(index, carga)">
                                            <i class="fa-solid fa-edit px" style="color: #ffffff;"></i>
                                        </SecondaryButton>
                                    </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <div class="-mx-3 px py-4" >
                                <div class="mx-3 py-2" v-if="$page.props.auth.user.rol == 2">
                                    <BorradorButton :disabled="form.processing" @click.prevent="submitForm(0,solicitudcarga)">
                                        <i class="fa-solid fa-save fa-lg"></i> Guardar como Borrador
                                    </BorradorButton>
                                </div>
                                <div class="mx-3 py-2" v-if="$page.props.auth.user.rol == 2">
                                    <PrimaryButton :disabled="form.processing" @click.prevent="submitForm(1,solicitudcarga)">
                                        <i class="fa-solid fa-right-from-bracket fa-lg" style="color: #ffffff;"></i> Guardar y Enviar
                                    </PrimaryButton>
                                </div>
                                <div class="mx-3 py-2" v-if="$page.props.auth.user.rol == 4">
                                    <BorradorButton :disabled="form.processing" @click.prevent="submitForm(1,solicitudcarga)">
                                        <i class="fa-solid fa-save fa-lg"> </i> Guardar como Borrador
                                    </BorradorButton>
                                </div>
                                <div class="mx-3 py-2" v-if="$page.props.auth.user.rol == 4">
                                    <PrimaryButton :disabled="form.processing" @click.prevent="createConocimiento(solicitudcarga)">
                                        <i class="fa-regular fa-clipboard fa-lg" style="color: #ffffff;"></i> Realizar Conocimiento Carga
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
