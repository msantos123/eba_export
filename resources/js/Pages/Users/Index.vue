<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { Head } from '@inertiajs/vue3';
import { defineProps, ref, computed } from 'vue';
import GreenButton from '@/Components/GreenButton.vue';
import Swal from 'sweetalert2';
import TextInput from '@/Components/TextInput.vue';
import BlueButton from '@/Components/BlueButton.vue';

const props = defineProps({
    usuarios: { type: Array, required: true,},
    roles: {type: Object, requier: true,}

});
const modal = ref(false);
const selectedUser = ref({});
const selectedRole = ref(null);

const openModal = (user) => {
    selectedUser.value = user;
    modal.value = true
};
const closeModal = () => {
    modal.value = false;
    location.reload();
};

const assignRole = async () => {
    console.log(selectedUser.value.usr_id);
    console.log(selectedRole.value);
    try {
        await axios.post('/roles/asignacion', {
            user_id: selectedUser.value.usr_id,
            roles: [selectedRole.value],
        });

        await Swal.fire({
            title: 'Éxito!',
            text: 'Rol asignado correctamente.',
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });

        closeModal();
    } catch (error) {
        console.error(error.response.data);

        await Swal.fire({
            title: 'Error!',
            text: 'Hubo un problema al asignar el rol.',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
};

const searchQuery = ref('');
const filteredUsuarios = computed(() => {
    return props.usuarios.filter(user => {
        return (
            user.usr_id.toString().includes(searchQuery.value) ||
            user.usr_usuario.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            user.usr_estado.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
    });
});
//paginacion
const currentPage = ref(1);
const itemsPerPage = ref(10);
// Propiedad computada para paginar
const paginatedUsuarios = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    return filteredUsuarios.value.slice(start, start + itemsPerPage.value);
});

// Calcular el total de páginas
const totalPages = computed(() => {
    return Math.ceil(filteredUsuarios.value.length / itemsPerPage.value);
});

// Navegación de páginas
const goToPage = (page) => {
    if (page > 0 && page <= totalPages.value) {
        currentPage.value = page;
    }
};
</script>
<template>
    <Head title="Users" />

    <AuthenticatedLayout>
        <template #header>
            Usuarios
        </template>
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
                            Usuario
                        </th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Estado
                        </th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Rol
                        </th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Editar Accesos
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in paginatedUsuarios" :key="user.usr_id" class="text-gray-700">
                        <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ user.usr_id }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ user.usr_usuario }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ user.usr_estado }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ user.name }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-5 py-3 text-sm">
                            <SecondaryButton @click="$event=>openModal(user)">
                                <i class="fa-solid fa-edit"></i>
                            </SecondaryButton>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-4 flex justify-center border-b border-gray-200 bg-white px-3 py-3 text-sm">
                <BlueButton
                    @click="goToPage(currentPage - 1)"
                    :disabled="currentPage === 1"
                    class="px-4 py-2"
                >
                    Anterior
                </BlueButton>
                <span class="mx-2 py-2">
                    Página {{ currentPage }} de {{ totalPages }}
                </span>
                <BlueButton
                    @click="goToPage(currentPage + 1)"
                    :disabled="currentPage === totalPages.value"
                    class="px-4 py-2 "
                >
                    Siguiente
                </BlueButton>
            </div>
        </div>

        <Modal :show="modal" @close="closeModal">

                <div class="w-full whitespace-no-wrap">
                    <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                        <div class="border-b-2 px-4 py-2 text-left text-xs tracking-wider">
                            <h2 class="p-3 text-lg font-medium text-gray-900">Asigna un Rol</h2>
                            <table class="w-full whitespace-no-wrap">
                                <thead>
                                    <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                        <th class="border-b-2 border-gray-200 bg-gray-100 px-2 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                            Usuario
                                        </th>
                                        <th class="border-b-2 border-gray-200 bg-gray-100 px-2 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                            Roles
                                        </th>
                                        <th class="border-b-2 border-gray-200 bg-gray-100 px-2 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                            Accion
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-gray-700">
                                        <td class="border-b border-gray-200 bg-white px-2 py-2 text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">{{ selectedUser.usr_usuario }}</p>
                                        </td>
                                        <td class="border-b border-gray-200 bg-white px-2 py-2 text-sm">
                                            <select v-model="selectedRole" id="roles" class="border rounded p-1">
                                                <option v-for="role in roles" :key="role.id" :value="role.name">
                                                    {{ role.name }}
                                                </option>
                                            </select>
                                        </td>
                                        <td class="border-b border-gray-200 bg-white px-2 py-2 text-sm">
                                            <GreenButton @click="assignRole">
                                                Asignar Rol
                                            </GreenButton>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

        </Modal>
    </AuthenticatedLayout>
</template>

