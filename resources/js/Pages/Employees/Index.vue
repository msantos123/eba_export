<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import WarningButton from '@/Components/WarningButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import Swal from 'sweetalert2';
import vueTailwindPagination from '@ocrv/vue-tailwind-pagination';

const nameInput = ref(null);
const modal = ref(false);
const title = ref('');
const operation = ref(1);
const id = ref('');

const props = defineProps({
    departments: {
        type: Object,
    },

    employees: {
        type: Object,
    },
});


const form = useForm({
    name:'',
    email:'',
    phone:'',
    department_id:'',
});

const formPage = useForm({});
const onPageClick = (event)=>{
    formPage.get(route('employees.index', {page:event}));
}
const openModal = (op,name,email,phone,department,employee)=>{
    console.log(name);
    console.log(employee);
    modal.value = true;
    nextTick(() =>nameInput.value.focus());
    operation.value = op;
    id.value = employee;
    if(op == 1){
        title.value = 'Crear Empleado';
    }
    else
    {
        title.value = 'Editar Empleado';
        form.name=name;
        form.email=email;
        form.phone=phone;
        form.department_id=department;
    }
}

const closeModal = () => {
        modal.value = false;
        form.reset();
    }

const save = () => {
    if(operation.value == 1){
        form.post(route('employees.store'),{
            onSuccess: () => {ok('Empleado Registrado')},
        })
    }else{
        form.put(route('employees.update',id.value),{
            onSuccess: () => {ok('Empleado Actualizado')},
        })
    }
}

const ok = (msj) => {
    form.reset();
    closeModal();
    Swal.fire({title:msj,icon:'success'});
}

const deleteEmployee = (id, name) =>{
    const alerta = Swal.mixin({
        buttonsStyling:true
    });
    alerta.fire({
        title:'Esta seguro de eliminar '+name+'?',
        icon: 'question', showCancelButton:true,
        confirmButtonText:'<i class="fa-solid fa-check"></i> Si, borrar.',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar.',
    }).then((result)=>{
        if(result.isConfirmed){
            form.delete(route('employees.destroy',id),{
                onSuccess: () => {ok('Empleado Eliminado')}
            });
        }
    });
}
</script>

<template>
    <Head title="Empleados" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Empleados</h2>
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
                <table class=" w-full whitespace-no-wrap">
                    <thead>
                        <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                #</th>
                                <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    Nombre</th>
                                    <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Email</th>
                                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                            Celular</th>
                                            <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Departamento</th>
                                                <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                </th>
                                                <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="emp, i in employees.data" :key="emp.id">
                            <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ (i+1) }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ emp.name }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ emp.email }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ emp.phone }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ emp.department }}</p>
                        </td>
                            <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                                <WarningButton @click="$event=>openModal(2,emp.name,emp.email,emp.phone,emp.department_id,emp.id)">
                                    <i class="fa-solid fa-edit"></i>
                                </WarningButton>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                                <DangerButton @click="$event=>deleteEmployee(emp.id, emp.name)">
                                    <i class="fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="bg-white grid v-screen place-items-center">
                <vueTailwindPagination
                :current="employees.currentPage" :total="employees.total"
                :per-page="employees.perPage"
                @page-changed="$event => onPageClick($event)"
                >
                </vueTailwindPagination>
            </div>

        <Modal :show="modal" @close="closeModal">
            <h2 class="p-3 text-lg font.medium text-hray-900">{{ title }}</h2>
            <div class="p-3">
                <InputLabel for="name" value="Name:"></InputLabel>
                <TextInput id="name" ref="nameInput"
                v-model="form.name" type="text" class="mt-1 block w-3/4"
                placeholder="Name"></TextInput>
                <InputError :message="form.errors.name" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="email" value="Email:"></InputLabel>
                <TextInput id="email" ref="emailInput"
                v-model="form.email" type="text" class="mt-1 block w-3/4"
                placeholder="Name"></TextInput>
                <InputError :message="form.errors.name" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="phone" value="Phone:"></InputLabel>
                <TextInput id="phone" ref="phoneInput"
                v-model="form.phone" type="text" class="mt-1 block w-3/4"
                placeholder="Phone"></TextInput>
                <InputError :message="form.errors.name" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="department_id" value="Departamentasdo"></InputLabel>
                <SelectInput id="department_id" :options="departments"
                v-model="form.department_id" class="mt-1 block w-3/4">
                </SelectInput>
                <InputError :message="form.errors.department_id" class="mt-2"></InputError>
            </div>
            <div class="p-3 mt-6">
                <PrimaryButton :disabled="form.processing" @click="save">
                    <i class="fa-solid fa-save"></i>Guardar
                </PrimaryButton>
            </div>
            <div class="p-3 mt-6 flex justify-end">
                <SecondaryButton class="ml-3" :disabled="form.processing" @click="closeModal">
                    <i class="fa-solid fa-save"></i>Cancel
                </SecondaryButton>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
