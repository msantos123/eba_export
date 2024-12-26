<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import { Head, Link } from '@inertiajs/vue3';
import { defineProps, ref, computed } from 'vue';
import GreenButton from '@/Components/GreenButton.vue';
import Swal from 'sweetalert2';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    roles: {type: Object, requier: true,}

});

const form = ref({
    name: '',
});

const modal = ref(false);
const selectedUser = ref({});
const selectedRole = ref(null);
const searchQuery = ref('');

const openModal = () => {
    modal.value = true
};
const closeModal = () => {
    modal.value = false;
    location.reload();
};

const createRole = async () => {
    try {
        await axios.post('/roles/store', form.value); // Asegúrate de que la ruta sea correcta

        await Swal.fire({
            title: 'Éxito!',
            text: 'Rol creado correctamente.',
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });

        closeModal(); // Cerrar el modal
        // Aquí puedes agregar lógica para actualizar la lista de roles si es necesario
    } catch (error) {
        console.error(error.response.data);
        await Swal.fire({
            title: 'Error!',
            text: 'Hubo un problema al crear el rol.',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
};

const filteredRoles = computed(() => {
    return props.roles.filter(rol => {
        return (
            rol.id.toString().includes(searchQuery.value) ||
            rol.name.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
    });
});

</script>
<template>
    <Head title="Users" />

    <AuthenticatedLayout>
        <template #header>
            Roles
        </template>

        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="px-4 py-3 flex">
                <div class="mr-2">
                    <GreenButton @click="openModal()"
                    class="inline-block rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-500 text-sm">
                    <i class="fa-regular fa-square-plus" style="color: #ffffff;"></i> Crear un Rol
                    </GreenButton>
                </div>
            </div>
        </div>

        <TextInput
            type="text"
            v-model="searchQuery"
            placeholder="Buscar por id, usuario, estado, rol..."
            class="border rounded p-2 mb-4"
        />
        <div class="min-w-full overflow-x-auto rounded-lg shadow">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            ID
                        </th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Rol
                        </th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Editar Permisos
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="rol in filteredRoles" :key="rol.usr_id" class="text-gray-700">
                        <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ rol.id }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ rol.name }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-2 py-3 text-sm">
                            <Link
                            :href="route('roles.show', rol.id)"
                            class="inline-block rounded-md bg-yellow-500 px-4 py-2 text-white hover:bg-yellow-400 text-sm">
                            <i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <Modal :show="modal" @close="closeModal">
    <div class="w-full whitespace-no-wrap">
        <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
            <div class="border-b-2 px-4 py-2 text-left text-xs tracking-wider">
                <h2 class="p-3 text-lg font-medium text-gray-900">Crea un Rol</h2>
                <form @submit.prevent="createRole">
                    <div>
                        <InputLabel for="roleName" class="block text-sm font-medium text-gray-700">Nombre del Rol</InputLabel>
                        <TextInput
                            type="text"
                            v-model="form.name"
                            required
                            class="border rounded p-2 w-full mt-1"
                            placeholder="Ingrese nombre del rol"
                        />
                    </div>
                    <div class="mt-4">
                        <GreenButton type="submit">Crear</GreenButton>
                    </div>
                </form>
            </div>
        </div>
    </div>
</Modal>
    </AuthenticatedLayout>
</template>

