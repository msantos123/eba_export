<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import BlueButton from '@/Components/BlueButton.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Modal from '@/Components/Modal.vue';
import CargaPlanta from '@/Components/CargaPlanta.vue';
import TextInput from '@/Components/TextInput.vue';
import axios from 'axios';
import Swal from 'sweetalert2';

const props = defineProps({
    cargas: { type: Array },
    planta_id: { type: String},
    solicitudcarga: { type: Object },
    salidaInventario: { type:Object },
})

const form = useForm({
    planta_id:props.planta_id,
    salida_inventario:'',
});

const selectedRow = ref(null);

const formatDate = (dateString) => {
  if (!dateString) return '';
  const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
  return new Date(dateString).toLocaleDateString('es-ES', options);
};

const handleCheckboxChange = (sal, isChecked) => {
  if (isChecked) {
    selectedRow.value = sal;
  } else {
    selectedRow.value = null;
  }
};
//codigo del modal
const modalPlanta = ref(false);
const plantaData = ref(null);

const openModalPlanta = async (mvpt_id) => {
    modalPlanta.value = true;
        try {
            const response = await axios.get(`/sigaSalidaDetalle/verSalidaPlanta/${mvpt_id}`);
            plantaData.value = response.data;
            console.log(plantaData);
        } catch (error) {
            console.error('Error al obtener los datos:', error);
        }
};

const closeModal = () => {
    modalPlanta.value = false;
    form.reset();
};

const showMessage = ref(false);
const message = ref('');


const submitForm = async () => {

    if (selectedRow.value) {
        const { salida_detalle, ...rest } = selectedRow.value;

        // Itera sobre los detalles de salida
        if (salida_detalle && salida_detalle.length > 0) {
            let allMatch = true;

            salida_detalle.forEach(det => {
            const { mvdpt_rece_id, mvdpt_lote, total_cantidad } = det;

                // Inicializa las banderas de coincidencia
                let productMatch = false;
                let loteMatch = false;
                let cantidadMatch = false;

                    // Compara con cada item en props.cargas
                    props.cargas.forEach(item => {
                    // Verifica el producto
                    if (item.receta_id === mvdpt_rece_id) {
                        productMatch = true;
                    }
                    // Verifica el lote
                    let lote = '';
                    const plantaId = Number(props.planta_id);
                    switch (plantaId) {
                        case 9:
                            lote = 'FOR.-' + String(mvdpt_lote).padStart(3, '0') + '(EA)';
                            break;
                        case 10:
                            lote = 'EA-' + String(mvdpt_lote).padStart(3, '0');
                            break;
                        case 25:
                            lote = 'FO-' + String(mvdpt_lote).padStart(3, '0') + '(EA)';
                            break;
                        default:
                            lote = 'DEFAULT-0' + String(mvdpt_lote).padStart(2, '0');
                            break;
                    }

                    if (item.lote === lote) {
                        loteMatch = true;
                    }
                    // Verifica la cantidad
                    if (Math.round(total_cantidad) === item.cantidad) {
                        cantidadMatch = true;
                    }
                });

                if (!productMatch) {
                    showMessageWithText('Los productos no coincide con ninguna solicitud de carga.');
                    allMatch = false;
                    return false;
                }
                if (!loteMatch) {
                    showMessageWithText(`El lote ${mvdpt_lote} de la Salida de Planta no coincide con ninguna de solicitud de carga.`);
                    allMatch = false;
                    return false;
                }
                if (!cantidadMatch) {
                    showMessageWithText(`La cantidad ${total_cantidad} de la Salida de Planta no coincide con ninguna solicitud de carga.`);
                    allMatch = false;
                    return false;
                }
                // Si todas las comparaciones coinciden
            if (allMatch) {
                Swal.fire({
                    title: '¿Está seguro?',
                    text: '¿Desea asignar nro. de salida a la solicitud de carga?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, guardar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Preparar los datos a enviar
                        const dataToSend = {
                            solicitudcarga: props.solicitudcarga,
                            salida_detalle: salida_detalle
                        };
                        // Realiza la actualización
                        const form = axios;

                        console.log(dataToSend);

                        form.put(route('solicitudcargas.update', dataToSend))
                        .then(response => {
                            console.log('Respuesta del servidor:', response); // Log para ver la respuesta del controlador
                                Swal.fire({
                                title: 'Guardado!',
                                text: 'Los cambios han sido guardados.',
                                icon: 'success',
                                willClose: () => {
                                     //Redirecciona a la página de solicitudes de carga después de que se cierre el modal
                                    window.location.href = route('solicitudcargas.index');
                                }
                            });
                        })
                        .catch(error => {
                            console.error('Error al guardar:', error); // Log para ver el error en caso de fallo
                            Swal.fire('Error!', 'Ocurrió un error al guardar los cambios.', 'error');
                        });
                    }
                });
                }
            });
        } else {
            alert('No hay detalles en el registro seleccionado.');
        }
    } else {
        alert('No se ha seleccionado ningún registro.');
    }
};

const showMessageWithText = (text) => {
    message.value = text;
    showMessage.value = true;
    setTimeout(() => {
        showMessage.value = false;
    }, 5000);
};

//buscador
const searchQuery = ref('');
const filtered = computed(() => {
    return props.salidaInventario.filter(sal => {
        return (
            sal.mvmvpt_nro.toString().includes(searchQuery.value.toLowerCase()) ||
            sal.created_at.toString().includes(searchQuery.value.toLowerCase())
        );
    });
});
//paginacion
const currentPage = ref(1);
const itemsPerPage = ref(10);
// Propiedad computada para paginar
const paginated = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    return filtered.value.slice(start, start + itemsPerPage.value);
});

// Calcular el total de páginas
const totalPages = computed(() => {
    return Math.ceil(filtered.value.length / itemsPerPage.value);
});

// Navegación de páginas
const goToPage = (page) => {
    if (page > 0 && page <= totalPages.value) {
        currentPage.value = page;
    }
};
</script>

<template>
    <Head title="Actualizar Solicitud de Carga" />

    <AuthenticatedLayout>
        <template #header>
            Elejir Salida de Inventario
        </template>
        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md" >
            <div class="px-4 py-3 flex">
                <div class="mx-1" >
                    <Link :href="route('solicitudcargas.index')"
                    class="inline-block rounded-md bg-gray-500 px-4 py-2 text-white hover:bg-gray-400 text-sm">
                    <i class="fa-solid fa-left-long" style="color: #ffffff;"></i> Volver
                    </Link>
                </div>
                <div class="mx-1">
                    <BlueButton :disabled="form.processing" @click="submitForm()">
                    <i class="fa-solid fa-file-circle-plus fa-lg" style="color: #ffffff;"></i> Aceptar Solicitud de Carga</BlueButton>
                </div>
            </div>
        </div>

    <div v-if="showMessage" class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-red-200 shadow-md">
        <div class="px-4 py-3 flex">
            <div  class="text-red-500">
                {{ message }}
            </div>
        </div>
    </div>
    <div class="min-w-full overflow-x-auto rounded-lg shadow">
        <div class="w-full whitespace-no-wrap">
            <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                    <CargaPlanta :cargas = "cargas" />
                    <br>

        <TextInput
            type="text"
            v-model="searchQuery"
            placeholder="Buscar por nro. salida, fecha..."
            class="border rounded p-2 mb-4"
        />
                    <InputLabel value="Selecionar Nro. Salida de Planta" class="text-lg font-maximo pb-2 border-b border-gray-300"/>
                            <br>
                            <table class="w-full border-collapse font-semibold uppercase">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="px-4 py-2">Nro</th>
                                        <th class="px-4 py-2">Nro. Salida</th>
                                        <th class="px-4 py-2">Fecha</th>
                                        <th class="px-4 py-2">Tipo</th>
                                        <th class="px-4 py-2">Detalle</th>
                                        <th class="px-4 py-2">Lote - Cantidad</th>
                                        <th class="px-4 py-2">Tipo Detalle</th>
                                        <th class="px-4 py-2">Selecionar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="sal, i in paginated" :key="sal.mvpt_id"class="border-b">
                                        <td class="px-4 py-2"> {{ i + 1 }} </td>
                                        <td class="px-4 py-2"> {{ sal.mvmvpt_nro }} </td>
                                        <td class="px-4 py-2"> {{ formatDate(sal.created_at) }}  </td>
                                        <td class="px-4 py-2"> {{ sal.mvmvpt_tipo }} </td>
                                        <td class="px-4 py-2"> {{ sal.mvmvpt_tipo_det }} </td>
                                        <td class="px-4 py-2">
                                            <ul>
                                                <li v-for="det in sal.salida_detalle">
                                                {{ det.rece_nombre }} <br>
                                                Lote: {{ det.mvdpt_lote }}
                                                Cantidad: {{ det.total_cantidad }}
                                                <hr>
                                                </li>
                                            </ul>
                                        </td>
                                        <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                            <BlueButton @click="openModalPlanta(sal.mvpt_id)">
                                                <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                                            </BlueButton>
                                        </td>
                                        <td class="px-4 py-2">
                                            <input
                                            type="checkbox"
                                            :value="sal.mvpt_id"
                                            :checked="selectedRow && selectedRow.mvpt_id === sal.mvpt_id"
                                            @change="handleCheckboxChange(sal, $event.target.checked)"
                                            />
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
            </div>
        </div>
    </div>
    <Modal :show="modalPlanta" @close="closeModal">
        <div class="min-w-full overflow-x-auto rounded-lg shadow">
            <div class="w-full whitespace-no-wrap">
                <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                    <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider"></div>
                    <h2 class="p-3 text-lg font-medium text-gray-900">Detalle de Salida de Planta</h2>
                        <div class="p-3">
                            <table class="min-w-full border-collapse border border-gray-300">
                                <thead>
                                    <tr>
                                        <th class="border border-gray-300 p-2">#</th>
                                        <th class="border border-gray-300 p-2">Producto</th>
                                        <th class="border border-gray-300 p-2">Nro. Lote</th>
                                        <th class="border border-gray-300 p-2">Cantidad</th>
                                        <th class="border border-gray-300 p-2">Fecha Elaboracion</th>
                                        <th class="border border-gray-300 p-2">Fecha Envasado</th>
                                        <th class="border border-gray-300 p-2">Fecha Vencimiento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(planta, index) in plantaData" :key="index">
                                        <td class="border border-gray-300 p-2">{{ index + 1 }}</td>
                                        <td class="border border-gray-300 p-2">{{ planta.rece_nombre }}</td>
                                        <td class="border border-gray-300 p-2">{{ planta.mvdpt_lote }}</td>
                                        <td class="border border-gray-300 p-2">{{ planta.mvdpt_cantidad }}</td>
                                        <td class="border border-gray-300 p-2">{{ planta.mvdpt_fec_elaboracion }}</td>
                                        <td class="border border-gray-300 p-2">{{ planta.mvdpt_fec_envasado }}</td>
                                        <td class="border border-gray-300 p-2">{{ planta.mvdpt_fec_vencimiento }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </Modal>
    </AuthenticatedLayout>
</template>
