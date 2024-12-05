<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref, defineProps } from 'vue';
import CargaPlanta from '@/Components/CargaPlanta.vue';
import TextDisabled from '@/Components/TextDisabled.vue';
import BorradorButton from '@/Components/BorradorButton.vue';
import BlueButton from '@/Components/BlueButton.vue';
import Swal from 'sweetalert2';
import axios from 'axios';

const props = defineProps({
    conocimientos: { type: Object, },
    solicitudcarga: { type: Object, },
    cargas: { type: Object, },
})
const form = useForm({
    id: props.conocimientos.id,
    codigo:props.conocimientos.codigo,
    empresa:props.conocimientos.empresa,
    conductor:props.conocimientos.conductor,
    vehiculo:props.conocimientos.vehiculo,
    propietario:props.conocimientos.propietario,
    licencia:props.conocimientos.licencia,
    placa:props.conocimientos.placa,
    celular:props.conocimientos.celular,
    planta_id:props.solicitudcarga.planta_id,
    status: '',

});

const submitForm = (status, conocimientos) => {
    const data = {
        id: conocimientos.id,
        codigo: form.codigo,
        empresa: form.empresa,
        conductor: form.conductor,
        vehiculo: form.vehiculo,
        propietario: form.propietario,
        licencia: form.licencia,
        placa: form.placa,
        celular: form.celular,
        planta_id: form.planta_id,
        status: status,
    };

    Swal.fire({
        title: 'Actualizando...',
        text: 'Por favor, espere.',
        allowOutsideClick: false,
        onBeforeOpen: () => {
            Swal.showLoading();
        }
    });

    axios.put(route('conocimientos.update'), data)
        .then(response => {
            console.log('Respuesta del servidor:', response);
            if (response.data === 'Actualizado exitosamente') {
                Swal.fire({
                    title: 'Actualizado!',
                    text: 'Los cambios han sido actualizados.',
                    icon: 'success',
                    willClose: () => {
                        window.location.href = route('conocimientos.index');
                    }
                });
            } else {
                Swal.fire('Info!', 'Respuesta inesperada del servidor.', 'info');
            }
        })
        .catch(error => {
            if (error.response && error.response.status === 422) {
                // Manejo de errores de validación
                const errors = error.response.data.errors;
                for (const field in errors) {
                    // Aquí puedes manejar cada error como desees
                    console.error(`Error en ${field}: ${errors[field].join(', ')}`);
                    // Mostrar el error en el formulario
                    form.errors[field] = errors[field]; // Asegúrate de tener un objeto para errores
                }
                Swal.fire('Errores!', 'Por favor corrige los errores en el formulario.', 'error');
            } else {
                console.error('Error al guardar:', error);
                Swal.fire('Error!', 'Ocurrió un error al guardar los cambios.', 'error');
            }
        });
};

</script>

<template>
    <Head title="Editar Conocimiento" />
    <AuthenticatedLayout>
        <template #header>
            Actualizar Conocimiento de Carga
        </template>
        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md" >
            <div class="px-4 py-3 flex">
                <div class="mx-1">
                    <Link :href="route('conocimientos.index')"
                    class="inline-block rounded-md bg-gray-500 px-4 py-2 text-white hover:bg-gray-400 text-sm">
                    <i class="fa-solid fa-left-long" style="color: #ffffff;"></i> Volver
                    </Link>
                </div>
                <div class="mx-1">
                    <BorradorButton :disabled="form.processing" @click.prevent="submitForm(0,conocimientos)">
                    <i class="fa-solid fa-save fa-lg"> </i> Guardar Borrador</BorradorButton>
                </div>
                <div class="mx-1">
                    <BlueButton :disabled="form.processing" @click.prevent="submitForm(1,conocimientos)">
                    <i class="fa-solid fa-file-circle-plus fa-lg" style="color: #ffffff;"></i> Enviar Conocimiento Carga</BlueButton>
                </div>
            </div>
        </div>
    <div class="min-w-full overflow-x-auto rounded-lg shadow">
        <div class="w-full whitespace-no-wrap">
            <div class="border-b bg-gray-50 text-left text-xs uppercase tracking-wide text-gray-500">
                <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                    <InputLabel value="Datos de Conocimiento de Carga" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                    <form @submit.prevent="$event=>form.put(route('conocimientos.update',conocimientos))">
                        <div class="grid grid-cols-4 gap-4 mt-4">
                            <div>
                                <InputLabel for="planta" value="Codigo"></InputLabel>
                                <TextDisabled id="planta" type="text" class="mt-2 block w-full"
                                v-model="form.codigo" disabled></TextDisabled>
                            </div>
                            <div>
                                <InputLabel for="empresa" value="Empresa Transportista"></InputLabel>
                                <TextInput id="empresa" type="text" class="mt-2 block w-full"
                                v-model="form.empresa" autofocus required
                                placeholder="Ej. Trans Huayana Kapac SRL."></TextInput>
                                <InputError :message="form.errors.empresa" class="mt-2"></InputError>
                            </div>
                            <div>
                                <InputLabel for="conductor" value="Conductor"></InputLabel>
                                <TextInput id="conductor" type="text" class="mt-2 block w-full"
                                v-model="form.conductor" autofocus required
                                placeholder="Ej. Dionicio Perez Quispe"></TextInput>
                                <InputError :message="form.errors.conductor" class="mt-2"></InputError>
                            </div>
                            <div>
                                <InputLabel for="vehiculo" value="Vehiculo"></InputLabel>
                                <TextInput id="vehiculo" type="text" class="mt-2 block w-full"
                                v-model="form.vehiculo" autofocus required
                                placeholder="Ej. Camion Tráile Volvo Blanco"></TextInput>
                                <InputError :message="form.errors.vehiculo" class="mt-2"></InputError>
                            </div>
                        </div>
                        <div class="grid grid-cols-4 gap-4 mt-4">
                            <div>
                                <InputLabel for="propietario" value="Propietario"></InputLabel>
                                <TextInput id="propietario" type="text" class="mt-2 block w-full"
                                 v-model="form.propietario" autofocus required
                                 placeholder="Ej. Irenea Camacho Soliz"></TextInput>
                                <InputError :message="form.errors.propietario" class="mt-2"></InputError>
                            </div>
                            <div>
                                <InputLabel for="licencia" value="Licencia"></InputLabel>
                                <TextInput id="licencia" type="text" class="mt-2 block w-full"
                                v-model="form.licencia" autofocus required
                                placeholder="Ej. 8323421 LP"></TextInput>
                                <InputError :message="form.errors.licencia" class="mt-2"></InputError>
                            </div>
                            <div>
                                <InputLabel for="placa" value="Placa"></InputLabel>
                                <TextInput id="placa" type="text" class="mt-2 block w-full"
                                v-model="form.placa" autofocus required
                                placeholder="Ej. 123-PLP"></TextInput>
                                <InputError :message="form.errors.placa" class="mt-2"></InputError>
                            </div>
                            <div>
                                <InputLabel for="celular" value="Celular"></InputLabel>
                                <TextInput id="celular" type="text" class="mt-2 block w-full"
                                 v-model="form.celular" autofocus required
                                 placeholder="Ej. 77373721"></TextInput>
                                <InputError :message="form.errors.celular" class="mt-2"></InputError>
                            </div>
                        </div>
                    </form>
                        <br>
                        <CargaPlanta :cargas="cargas"/>
                        <br>


                </div>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
