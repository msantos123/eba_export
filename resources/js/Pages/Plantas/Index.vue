<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import WarningButton from '@/Components/WarningButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import Swal from 'sweetalert2';

const nombreInput = ref(null);
const direccionInput = ref(null);
const tipoInput = ref(null);

const modal = ref(false);
const title = ref('');
const operation = ref(1);
const id = ref('');

const props = defineProps({
    plantas: {
        type: Object,
    },
});

const form = useForm({
    nombre:'',
    direccion:'',
    tipo: '',
});

const openModal = (op,nombre,direccion,tipo,planta)=>{
    modal.value = true;
    operation.value = op;
    id.value = planta;
    if(op == 1){
        title.value = 'Crear Planta';
    }
    else
    {
        title.value = 'Editar Planta';
        form.nombre=nombre;
        form.direccion=direccion;
        form.tipo=tipo;
    }
}

const closeModal = () => {
        modal.value = false;
        form.reset();
    }

const save = () => {
    if(operation.value == 1){
        form.post(route('plantas.store'),{
            onSuccess: () => {ok('Nueva plata registrada.')},
        })
    }else{
        form.put(route('plantas.update',id.value),{
            onSuccess: () => {ok('Planta actualizada')},
        })
    }
}

const ok = (msj) => {
    form.reset();
    closeModal();
    Swal.fire({title:msj,icon:'success'});
}


const cambiaEstado = (id, nombre) =>{
    const alerta = Swal.mixin({
        buttonsStyling:true
    });
    alerta.fire({
        title:'Esta seguro que desea cambiar el estado de '+nombre+'?',
        icon: 'question', showCancelButton:true,
        confirmButtonText:'<i class="fa-solid fa-check"></i> Si.',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar.',
    }).then((result)=>{
        if(result.isConfirmed){
            form.get(route('plantas.active',id),{
                onSuccess: () => {ok('Estado Actualizado')}
            });
        }
    });
}
</script>

<template>
    <Head title="Plantas" />

    <AuthenticatedLayout>
        <template #header>
            Plantas y Almacenes
        </template>
        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="-mx-3 px-4 py-2">
                <div class="mx-3">
                    <PrimaryButton @click = "$event => openModal(1)">
                        <i class="fa-solid fa-plus-circle"></i> Adicionar
                    </PrimaryButton>
                </div>
            </div>
        </div>

            <div class="min-w-full overflow-x-auto rounded-lg shadow">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                #
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Nombre
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Dirección
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Tipo
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Estado
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Editar
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Desactivar
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="pla, i in plantas" :key="pla.id">
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ (i+1) }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ pla.nombre }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ pla.direccion }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ pla.tipo }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-5 py-3 text-sm">
                                <span v-if="pla.estado === '0'" class="bg-gray-300 px-2 py-1 rounded-md">NoActivo</span>
                                <span v-else-if="pla.estado === '1'" class="bg-green-400 px-2 py-1 rounded-md">Activo</span>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <SecondaryButton @click="$event=>openModal(2,pla.nombre,pla.direccion,pla.tipo,pla.id)">
                                    <i class="fa-solid fa-edit"></i>
                                </SecondaryButton>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-5 py-3 text-sm">
                                <WarningButton @click="() => cambiaEstado(pla.id, pla.nombre)">
                                    <i class="fa-solid fa-cancel"></i>
                                </WarningButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        <Modal :show="modal" @close="closeModal">
            <h2 class="p-3 text-lg font.medium text-hray-900">{{ title }}</h2>
            <div class="p-3">

                <InputLabel for="nombre" value="Nombre:"></InputLabel>
                <TextInput id="nombre" ref="nombreInput" v-model="form.nombre" type="text" placeholder="Ej. Planta - Oficina - Almacen"></TextInput>
                <InputError :message="form.errors.nombre" class="mt-2"></InputError>

                <InputLabel for="direccion" value="Direccion:"></InputLabel>
                <TextInput id="direccion" ref="direccionInput" v-model="form.direccion" type="text" placeholder="Ej. Av. Carrasco Zona Central Nro. 1000"></TextInput>
                <InputError :message="form.errors.nombre" class="mt-2"></InputError>

                <InputLabel for="tipo" value="Tipo:" ref="tipoInput"></InputLabel>
                <select id="tipo" v-model="form.tipo" class="mt-1 block w-full rounded-md">
                    <option value="">-- Seleccionar Tipo --</option>
                    <option value="Almacen">Almacen</option>
                    <option value="Oficina">Oficina</option>
                    <option value="Planta">Planta</option>
                </select>
                <InputError :message="form.errors.nombre" class="mt-2"></InputError>
            </div>
            <div class="p-3 mt-6 flex justify-between">
                <PrimaryButton :disabled="form.processing" @click="save">
                    <i class="fa-solid fa-save"></i> Guardar
                </PrimaryButton>
                <WarningButton :disabled="form.processing" @click="closeModal">
                    <i class="fa-solid fa-cancel"></i> Cancelar
                </WarningButton>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
