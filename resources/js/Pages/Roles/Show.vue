<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import GreenButton from '@/Components/GreenButton.vue';
import { ref, defineProps, computed } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    rol_permisos: { type: Object, required: true },
    permisos: { type: Array, required: true },
});

const selectedPermissions = ref(props.rol_permisos.permissions ? props.rol_permisos.permissions.map(p => p.id) : []);

const savePermissions = async () => {
    try {
        await axios.post(`/roles/${props.rol_permisos.id}/permissions`, {
            permissions: selectedPermissions.value,
        });

        await Swal.fire({
            title: 'Éxito!',
            text: 'Permisos guardados correctamente.',
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
    } catch (error) {
        // Comprobar si error.response existe
        if (error.response) {
            console.error(error.response.data);
            await Swal.fire({
                title: 'Error!',
                text: 'Hubo un problema al guardar los permisos: ' + error.response.data.message,
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        } else {
            console.error(error);
            await Swal.fire({
                title: 'Error!',
                text: 'Hubo un problema al guardar los permisos. Intenta nuevamente.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    }
};
//buscador
const searchQuery = ref('');
const filteredPermisos = computed(() => {
    return props.permisos.filter(permisos => {
        return (
            permisos.id.toString().includes(searchQuery.value) ||
            permisos.name.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
    });
});
</script>

<template>
    <Head title="Editar Conocimiento" />
    <AuthenticatedLayout>
        <template #header>
            Permisos del Rol: {{ rol_permisos.name }}
        </template>

        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="px-4 py-3 flex">
                <div class="mx-1">
                    <Link :href="route('roles.index')"
                    class="inline-block rounded-md bg-gray-500 px-4 py-2 text-white hover:bg-gray-400 text-sm">
                    <i class="fa-solid fa-left-long" style="color: #ffffff;"></i> Volver
                    </Link>
                </div>
                <div class="mx-1">
                    <GreenButton @click.prevent="savePermissions() ">
                        <i class="fa-solid fa-floppy-disk" style="color: #ffffff;"></i> Guardar Permisos </GreenButton>
                </div>
            </div>
        </div>

        <TextInput
            type="text"
            v-model="searchQuery"
            placeholder="Buscar por id, permiso..."
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
                            Permiso
                        </th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Seleccion
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="permiso in filteredPermisos" :key="permiso.id" class="text-gray-700">
                        <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ permiso.id }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ permiso.name }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                            <input
                                type="checkbox"
                                :value="permiso.id"
                                v-model="selectedPermissions"
                                :checked="selectedPermissions.includes(permiso.id)"
                            />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>
