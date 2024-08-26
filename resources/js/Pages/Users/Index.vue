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
import Pagination from '@/Components/Pagination.vue'

const ci = ref(null);
const paterno = ref(null);
const materno = ref(null);
const name = ref(null);
const email = ref(null);
const celular = ref(null);

const modal = ref(false);
const title = ref('');
const operation = ref(1);
const id = ref('');

const props = defineProps({
    users: { type: Object, },
    plantas: { type: Object, },
    roles: { type: Object, },

});

const form = useForm({
    ci:'',
    paterno:'',
    materno:'',
    name:'',
    email:'',
    celular:'',
    planta_id:'',
    rol:'',
});


const openModal = (op,ci,paterno,materno,name,email,celular,planta_id,rol,usuario)=>{
    modal.value = true;
    nextTick(() =>ci.value.focus());
    nextTick(() =>paterno.value.focus());
    nextTick(() =>materno.value.focus());
    nextTick(() =>name.value.focus());
    nextTick(() =>email.value.focus());
    nextTick(() =>celular.value.focus());
    nextTick(() =>planta_id.value.focus());
    nextTick(() =>rol.value.focus());
    operation.value = op;
    id.value = usuario;
    if(op == 1){
        title.value = 'Crear Usuario';
    }
    else
    {
        title.value = 'Editar Usuario';
        form.ci=ci;
        form.paterno=paterno;
        form.materno=materno;
        form.name=name;
        form.email=email;
        form.celular=celular;
        form.planta_id=planta_id;
        form.rol=rol;
    }
}

const closeModal = () => {
        modal.value = false;
        form.reset();
    }

const save = () => {
    if(operation.value == 1){
        form.post(route('users.store'),{
            onSuccess: () => {ok('Usuario Registrado')},
        })
    }else{
        form.put(route('users.update',id.value),{
            onSuccess: () => {ok('Usuario Actualizado')},
        })
    }
}

const ok = (msj) => {
    form.reset();
    closeModal();
    Swal.fire({title:msj,icon:'success'});
}

const cambiaEstado = (id, ci) =>{
    const alerta = Swal.mixin({
        buttonsStyling:true
    });
    alerta.fire({
        title:'Esta seguro que desea cambiar el estado del usuario con CI '+ci+'?',
        icon: 'question', showCancelButton:true,
        confirmButtonText:'<i class="fa-solid fa-check"></i> Si, desactivar.',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar.',
    }).then((result)=>{
        if(result.isConfirmed){
            form.get(route('users.active',id),{
                onSuccess: () => {ok('Usuario Desactivado')}
            });
        }
    });
}
</script>
<template>
    <Head title="Users" />

    <AuthenticatedLayout>
        <template #header>
            Usuarios
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
                            CI
                        </th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Ap. Paterno
                        </th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Ap. Materno
                        </th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Nombres
                        </th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Email
                        </th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Celular
                        </th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Planta
                        </th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Rol
                        </th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Estado
                        </th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Editar
                        </th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Cambiar Estado
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users.data" :key="user.id" class="text-gray-700">
                        <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ user.ci }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ user.paterno }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ user.materno }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ user.name }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-5 py-3 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ user.email }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-5 py-3 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ user.celular }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-5 py-3 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ user.planta }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-5 py-3 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ user.role }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-5 py-3 text-sm">
                            <span v-if="user.estado === '0'" class="bg-gray-300 px-2 py-1 rounded-md">NoActivo</span>
                            <span v-else-if="user.estado === '1'" class="bg-green-400 px-2 py-1 rounded-md">Activo</span>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-5 py-3 text-sm">
                            <SecondaryButton @click="$event=>openModal(2,user.ci,user.paterno,user.materno,user.name,user.email,user.celular,user.planta_id,user.rol,user.id)">
                                <i class="fa-solid fa-edit"></i>
                            </SecondaryButton>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-5 py-3 text-sm">
                            <WarningButton @click="() => cambiaEstado(user.id, user.ci)">
                                <i class="fa-solid fa-cancel"></i>
                            </WarningButton>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <Modal :show="modal" @close="closeModal">
            <h2 class="p-3 text-lg font.medium text-hray-900">{{ title }}</h2>
            <div class="p-3 flex space-x-4">
                <div class="w-1/2">
                    <InputLabel for="ci" value="Carnet de Identidad:"></InputLabel>
                    <TextInput id="ci" ref="ci" v-model="form.ci" type="number" placeholder="Ej. 8323432"></TextInput>
                    <InputError :message="form.errors.ci" class="mt-2"></InputError>
                </div>
                <div class="w-1/2">
                    <InputLabel for="paterno" value="Apellido Paterno:"></InputLabel>
                    <TextInput id="paterno" ref="paterno" v-model="form.paterno" type="text" placeholder="Ej. Sandoval"></TextInput>
                    <InputError :message="form.errors.paterno" class="mt-2"></InputError>
                </div>
            </div>
            <div class="p-3 flex space-x-4">
                <div class="w-1/2">
                    <InputLabel for="materno" value="Apellido Materno:"></InputLabel>
                    <TextInput id="materno" ref="materno" v-model="form.materno" type="text" placeholder="Ej. Ergueta"></TextInput>
                    <InputError :message="form.errors.materno" class="mt-2"></InputError>
                </div>
                <div class="w-1/2">
                    <InputLabel for="name" value="Nombres:"></InputLabel>
                    <TextInput id="name" ref="name" v-model="form.name  " type="text" placeholder="Ej. Juan Jose"></TextInput>
                    <InputError :message="form.errors.name" class="mt-2"></InputError>
                </div>
            </div>
            <div class="p-3 flex space-x-4">
                <div class="w-1/2">
                    <InputLabel for="celular" value="Celular:"></InputLabel>
                    <TextInput id="celular" ref="celular" v-model="form.celular" type="number" placeholder="Ej. 77202828"></TextInput>
                    <InputError :message="form.errors.celular" class="mt-2"></InputError>
                </div>
                <div class="w-1/2">
                    <InputLabel for="email" value="Email:"></InputLabel>
                    <TextInput id="email" ref="email" v-model="form.email" type="text" placeholder="Ej. example@eba.bo"></TextInput>
                    <InputError :message="form.errors.email" class="mt-2"></InputError>
                </div>
            </div>
            <div class="p-3 flex space-x-4">
                <div class="w-1/2">
                    <InputLabel for="planta_id" value="Oficina, Planta o Almacen:"></InputLabel>
                    <select id="planta_id" v-model="form.planta_id" class="mt-1 block w-full rounded">
                        <option value="">-- Seleccione una opción --</option>
                        <option v-for="planta in plantas" :value="planta.id">{{ planta.nombre }}</option>
                    </select>
                    <InputError :message="form.errors.planta_id" class="mt-2"></InputError>
                </div>
                <div class="w-1/2">
                    <InputLabel for="rol" value="Rol:"></InputLabel>
                    <select id="rol" v-model="form.rol" class="mt-1 block w-full rounded">
                        <option value="">-- Seleccione una opción --</option>
                        <option v-for="rol in roles" :value="rol.id">{{ rol.nombre }}</option>
                    </select>
                    <InputError :message="form.errors.planta_id" class="mt-2"></InputError>
                </div>
            </div>

            <div class="p-3 mt-6 flex justify-between">
                <PrimaryButton :disabled="form.processing" @click="save">
                    <i class="fa-solid fa-save"></i> Guardar
                </PrimaryButton>
                <WarningButton class="ml-3" :disabled="form.processing" @click="closeModal">
                    <i class="fa-solid fa-cancel"></i> Cancelar
                </WarningButton>
            </div>
        </Modal>

    </AuthenticatedLayout>
</template>

