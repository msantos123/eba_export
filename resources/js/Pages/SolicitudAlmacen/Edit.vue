<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BlueButton from '@/Components/BlueButton.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref, computed  } from 'vue';
import CargaAlmacen from '@/Components/CargaAlmacen.vue';
import axios from 'axios';
import Swal from 'sweetalert2';

const props = defineProps({
    cargas: { type: Object },
    planta_id: { type: Number},
    solicitudcarga: { type: Object },
    salidaInventario: { type:Object },
})

const form = useForm({
    planta_id:props.planta_id,
    salida_inventario:'',
});

const allCargasComplete = computed(() => {
    if (Array.isArray(props.cargas)) {
        return props.cargas.every(car => car.estado === 1);
    }
    return false;
});

const submitForm = (solicitudcarga) => {
    const alerta = Swal.mixin({
        buttonsStyling: true,
    });

    alerta.fire({
        title: '¿Está seguro de actualizar la solicitud?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check"></i> Si, actualizar.',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar.',
    }).then((result) => {
        if (result.isConfirmed) {
            // Envía la solicitud si el usuario confirma
            axios.get(route('solicitudcargas.updateAlmacen', solicitudcarga), {
                // Incluye cualquier dato adicional si es necesario
            })
            .then(response => {
                // Muestra un mensaje de éxito
                Swal.fire({
                    title: 'Éxito!',
                    text: 'Solicitud actualizada exitosamente.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    // Opcional: redirigir a otra página después de cerrar el Swal
                    window.location.href = route('solicitudAlmacen.index'); // Ajusta según sea necesario
                });
            })
            .catch(error => {
                console.error('Error al actualizar la solicitud:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Ocurrió un error al actualizar la solicitud.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            });
        }
    });
};

</script>

<template>
    <Head title="Actualizar Solicitud de Carga" />

    <AuthenticatedLayout>
        <template #header>
            Elejir Fecha de Elaboracion de Carga
        </template>
    <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md" >
        <div class="px-4 py-3 flex">
                <div class="mx-1" >
                    <Link :href="route('solicitudAlmacen.index')"
                    class="inline-block rounded-md bg-gray-500 px-4 py-2 text-white hover:bg-gray-400 text-sm">
                    <i class="fa-solid fa-left-long" style="color: #ffffff;"></i> Volver
                    </Link>
                </div>
                <div class="mx-1">
                    <BlueButton :disabled="!allCargasComplete" @click="submitForm(solicitudcarga,selectedRow)">
                    <i class="fa-solid fa-file-circle-plus fa-lg" style="color: #ffffff;"></i> Aceptar Solicitud de Carga</BlueButton>
                </div>
        </div>
    </div>

    <div class="min-w-full overflow-x-auto rounded-lg shadow">
        <div class="w-full whitespace-no-wrap">
            <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                    <CargaAlmacen :cargas = "cargas" />
                    <br>
                    <p class="text-red-500 text-left"> Nota: Todos los Registros deben estar con Estado "Completo" para continuar. </p>
                </div>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
