<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextInput from '@/Components/TextInput.vue';
import CargaTable from '@/Components/CargaTable.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import FormConocimiento from '@/Components/FormConocimiento.vue';

const props = defineProps({
    kardex: {
        type: Object,
    },
});

const form = useForm({

});


defineEmits(['submit']);

</script>

<template>
    <Head title="Crear Conocimiento" />
    <AuthenticatedLayout>
        <template #header>
            Crear Comprobante de Salida
        </template>
    <div class="min-w-full overflow-x-auto rounded-lg shadow">
        <div class="w-full whitespace-no-wrap">
            <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                    <InputLabel value="Datos de Comprobante de Ingreso" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                    <form @submit.prevent="$event=>form.post(route('comprobante_ingreso.store'))">

                        <br>
                        <br>
                        <div class="-mx-3 px py-4">
                            <div class="mx-3">
                                <PrimaryButton :disabled="form.processing">
                                <i class="fa-solid fa-save text-xs"> </i> Registrar
                                </PrimaryButton>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
