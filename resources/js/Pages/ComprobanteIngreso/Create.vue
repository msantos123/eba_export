<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import GreenButton from '@/Components/GreenButton.vue';
import CargaPlanta from '@/Components/CargaPlanta.vue';
import { Head, useForm , Link} from '@inertiajs/vue3';
import FormConocimiento from '@/Components/FormConocimiento.vue';
import Swal from 'sweetalert2';
import axios from 'axios';

const props = defineProps({
    conocimiento: { type: Object },
    cargas: { type: Object },
    codigo: { type: String },
    solicitud:{ type:Object },
});

const form = useForm({
    codigo_ingreso: props.codigo,
    fecha_ingreso: new Date().toISOString().slice(0, 10),
    cefo: '',
    observaciones:'',
    conocimiento_id: props.conocimiento.id,

});

const submitForm = (form) => {
    // Usar Axios directamente para enviar la solicitud POST
    axios.post(route('comprobante_ingreso.store'), form)
        .then(response => {
            console.log(response);
            Swal.fire({
                title: 'Éxito!',
                text: 'Ingreso guardado exitosamente.',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                // Opcional: redirigir o realizar otra acción después de cerrar el Swal
                window.location.href = route('comprobante_ingreso.index'); // Cambia esto según sea necesario
            });
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
    <Head title="Crear Conocimiento" />
    <AuthenticatedLayout>
        <template #header>
            Crear Comprobante de Ingreso
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
                    <GreenButton :disabled="form.processing" @click.prevent="submitForm(form)">
                    <i class="fa-solid fa-save"></i> Guardar Comprobante Ingreso</GreenButton>
                </div>
            </div>
        </div>
    <div class="min-w-full overflow-x-auto rounded-lg shadow">
        <div class="w-full whitespace-no-wrap">
            <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                    <InputLabel value="Datos de Comprobante de Ingreso" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                    <form>
                        <div class="grid grid-cols-3 gap-4 mt-4">
                            <div>
                                <InputLabel for="empresa" value="Fecha de Ingreso"></InputLabel>
                                <TextInput id="fecha_inge" type="text" class="mt-2 block w-full"
                                v-model="form.fecha_ingreso" autofocus required
                                placeholder="Ej. Trans Huayana Kapac SRL."></TextInput>
                                <InputError :message="form.errors.fecha_ingreso" class="mt-2"></InputError>
                            </div>
                            <div>
                                <InputLabel for="empresa" value="Codigo de Ingreso"></InputLabel>
                                <TextInput id="empresa" type="text" class="mt-2 block w-full"
                                v-model="form.codigo_ingreso" autofocus required
                                placeholder="Ej. 003-24"></TextInput>
                                <InputError :message="form.errors.codigo_ingreso" class="mt-2"></InputError>
                            </div>
                            <div>
                                <InputLabel for="conductor" value="Nro. CEFO"></InputLabel>
                                <TextInput id="conductor" type="text" class="mt-2 block w-full"
                                v-model="form.cefo" autofocus required
                                placeholder="Ej. RIB-C2403208"></TextInput>
                                <InputError :message="form.errors.cefo" class="mt-2"></InputError>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-4 mt-4">
                            <div>
                                <InputLabel for="vehiculo" value="Observaciones"></InputLabel>
                                <TextInput id="vehiculo" type="text" class="mt-2 block w-full"
                                v-model="form.observaciones" autofocus required
                                placeholder="Ej. Cajas en mal estado"></TextInput>
                                <InputError :message="form.errors.observaciones" class="mt-2"></InputError>
                            </div>
                        </div>
                    </form>
                        <br>
                        <FormConocimiento :conocimiento="conocimiento" :solicitud="solicitud"/>
                        <br>
                        <CargaPlanta :cargas="cargas"/>
                        <br>

                </div>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
