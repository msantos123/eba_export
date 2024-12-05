<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import GreenButton from '@/Components/GreenButton.vue';
import CargaAlmacenTable from '@/Components/CargaAlmacen.vue';
import Swal from 'sweetalert2';

const props = defineProps({
    cargas: { type: Array, required:true },
    codigo: { type: String },
    comprobanteSalidas: { type: Object },
    solicitud_id: { type:String},

});

const form = useForm({
    solicitud_id: props.solicitud_id,
    fecha_salida: new Date().toISOString().slice(0, 10),
    empresa: '',
    responsable: '',
    camion:'',
    placa:'',
    licencia:'',
    celular:'',
    contenedor:'',
    presinto:'',
    reserva:'',
    factura:'',
    destino:'',
    codigo_salida: props.codigo,
    cargas:props.cargas,

});

const submitForm = () => {
    const alerta = Swal.mixin({
        buttonsStyling: true,
    });

    alerta.fire({
        title: '¿Está seguro de enviar el comprobante de salida?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check"></i> Si, enviar.',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar.',
    }).then((result) => {
        if (result.isConfirmed) {
            form.post(route('comprobante_salida.store'), {
                // Puedes incluir datos adicionales si es necesario
            }).then(response => {
                // Muestra un mensaje de éxito
                Swal.fire({
                    title: 'Éxito!',
                    text: 'Comprobante de salida creado exitosamente.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    // Redirige a la página de comprobantes
                    window.location.href = 'comprobante_salida'; // Ajusta la URL según sea necesario
                });
            }).catch(error => {
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
        }
    });
};

</script>

<template>
    <Head title="Crear Conocimiento" />
    <AuthenticatedLayout>
        <template #header>
            Crear Comprobante de Salida
        </template>
        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="px-4 py-3 flex">
                <div class="mx-1">
                    <Link :href="route('solicitudAlmacen.index')"
                    class="inline-block rounded-md bg-gray-500 px-4 py-2 text-white hover:bg-gray-400 text-sm">
                    <i class="fa-solid fa-left-long" style="color: #ffffff;"></i> Volver
                    </Link>
                </div>
                <div class="mx-1">
                    <GreenButton @click.prevent="submitForm()">
                    <i class="fa-solid fa-circle-check fa-lg" style="color: #ffffff;"></i> Guardar Salida</GreenButton>
                </div>
            </div>
        </div>
    <div class="min-w-full overflow-x-auto rounded-lg shadow">
        <div class="w-full whitespace-no-wrap">
            <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                    <InputLabel value="Datos de Comprobante de Ingreso" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                    <form>
                        <div class="grid grid-cols-4 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Fecha de Salida"/>
                                    <TextInput type="text" class="mt-2 block w-full" v-model="form.fecha_salida" required/>
                                    <InputError :message="form.errors.fecha_salida" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="Codigo de Salida"/>
                                    <TextInput type="text" class="mt-2 block w-full" v-model="form.codigo_salida" required/>
                                    <InputError :message="form.errors.codigo_salida" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="Nro. Factura"></InputLabel>
                                    <TextInput type="number" class="mt-2 block w-full"
                                    v-model="form.factura" required placeholder="Ej. 34"></TextInput>
                                    <InputError :message="form.errors.factura" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="Destino"></InputLabel>
                                    <TextInput list="form.destino" type="text" class="mt-2 block w-full"
                                    v-model="form.destino" required
                                    placeholder="Ej. SHANGHAI-CHINA"></TextInput>
                                    <datalist id="form.destino" >
                                        <option v-for="comprobanteSalida in comprobanteSalidas" :value="comprobanteSalida.destino "> {{ comprobanteSalida.destino }}</option>
                                    </datalist>
                                    <InputError :message="form.errors.destino" class="mt-2"></InputError>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Nro. Contenedor"></InputLabel>
                                    <TextInput list="form.contenedor" type="text" class="mt-2 block w-full"
                                    v-model="form.contenedor" autofocus required placeholder="Ej. MSMU8175110"></TextInput>
                                    <InputError :message="form.errors.contenedor" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="Nro. Presinto"></InputLabel>
                                    <TextInput list="form.presinto" type="text" class="mt-2 block w-full"
                                    v-model="form.presinto" autofocus required placeholder="Ej. EU26210622"></TextInput>
                                    <InputError :message="form.errors.presinto" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="Nro. Reserva"></InputLabel>
                                    <TextInput list="form.reserva" type="text" class="mt-2 block w-full"
                                    v-model="form.reserva" autofocus required placeholder="Ej. EBKG08586208"></TextInput>
                                    <InputError :message="form.errors.reserva" class="mt-2"></InputError>
                                </div>
                            </div>
                            <br>
                            <InputLabel value="Datos de Empresa" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                            <div class="grid grid-cols-3 gap-4 mt-4">
                                <div>
                                    <InputLabel for="empresa" value="Empresa Transportista"/>
                                    <TextInput list="form.empresa" type="text" class="mt-2 block w-full" v-model="form.empresa"
                                    placeholder="Ej. Trans Huayana Kapac SRL."/>
                                    <datalist id="form.empresa" >
                                        <option v-for="comprobanteSalida in comprobanteSalidas" :value="comprobanteSalida.empresa "> {{ comprobanteSalida.empresa }}</option>
                                    </datalist>
                                    <InputError :message="form.errors.empresa" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel for="conductor" value="Conductor"></InputLabel>
                                    <TextInput list="form.responsable" type="text" class="mt-2 block w-full"
                                    v-model="form.responsable" required placeholder="Ej. Dionicio Perez Quispe"></TextInput>
                                    <datalist id="form.responsable" >
                                        <option v-for="comprobanteSalida in comprobanteSalidas" :value="comprobanteSalida.responsable "> {{ comprobanteSalida.responsable }}</option>
                                    </datalist>
                                    <InputError :message="form.errors.responsable" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel for="vehiculo" value="Vehiculo"></InputLabel>
                                    <TextInput list="form.camion" type="text" class="mt-2 block w-full"
                                    v-model="form.camion" required placeholder="Ej. Camion Tráiler Volvo Blanco"></TextInput>
                                    <datalist id="form.camion" >
                                        <option v-for="comprobanteSalida in comprobanteSalidas" :value="comprobanteSalida.camion "> {{ comprobanteSalida.camion }}</option>
                                    </datalist>
                                    <InputError :message="form.errors.camion" class="mt-2"></InputError>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4 mt-4">
                                <div>
                                    <InputLabel for="licencia" value="Licencia"></InputLabel>
                                    <TextInput list="form.licencia" type="text" class="mt-2 block w-full"
                                    v-model="form.licencia" autofocus required placeholder="Ej. 8323421 LP"></TextInput>
                                    <datalist id="form.licencia" >
                                        <option v-for="comprobanteSalida in comprobanteSalidas" :value="comprobanteSalida.licencia "> {{ comprobanteSalida.licencia }}</option>
                                    </datalist>
                                    <InputError :message="form.errors.licencia" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel for="placa" value="Placa"></InputLabel>
                                    <TextInput list="form.placa" type="text" class="mt-2 block w-full"
                                    v-model="form.placa" autofocus required placeholder="Ej. 420-WED"></TextInput>
                                    <datalist id="form.placa" >
                                        <option v-for="comprobanteSalida in comprobanteSalidas" :value="comprobanteSalida.placa "> {{ comprobanteSalida.placa }}</option>
                                    </datalist>
                                    <InputError :message="form.errors.placa" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel for="celular" value="Celular"></InputLabel>
                                    <TextInput list="form.celular" type="number" class="mt-2 block w-full"
                                    v-model="form.celular" autofocus required
                                    placeholder="Ej. 77373721"></TextInput>
                                    <datalist id="form.celular" >
                                        <option v-for="comprobanteSalida in comprobanteSalidas" :value="comprobanteSalida.celular "> {{ comprobanteSalida.celular }}</option>
                                    </datalist>
                                    <InputError :message="form.errors.celular" class="mt-2"></InputError>
                                </div>
                            </div>
                            <br>
                            <CargaAlmacenTable :cargas = "cargas" />
                    </form>
                </div>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
