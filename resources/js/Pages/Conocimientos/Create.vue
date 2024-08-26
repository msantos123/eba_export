<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import BlueButton from '@/Components/BlueButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextDisabled from '@/Components/TextDisabled.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import CargaTable from '@/Components/CargaTable.vue';
import SolicitudCarga from '@/Components/SolicitudCarga.vue';

const props = defineProps({
    conocimientos : { type: Object },
    cargas: { type: Object },
    solicitudcarga: { type: Object },
});

const form = useForm({
    planta:props.solicitudcarga.planta_nombre,
    solicitud_id:props.solicitudcarga.id,
    empresa:'',
    conductor:'',
    vehiculo:'',
    propietario:'',
    licencia:'',
    placa:'',
    celular:'',
});

const submitForm = (status,solicitudcarga) => {
    form.status = status;
    form.post(route('conocimientos.store',solicitudcarga), {
    });
}
</script>

<template>
    <Head title="Crear Conocimiento" />
    <AuthenticatedLayout>
        <template #header>
            Crear Conocimiento de Carga
        </template>
        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md" >
            <div class="px-4 py-3 flex">
                <div class="mx-1">
                    <BlueButton :disabled="form.processing" @click.prevent="submitForm(1,solicitudcarga)">
                    <i class="fa-solid fa-save"></i> Guardar</BlueButton>
                </div>
            </div>
        </div>
        <div class="min-w-full overflow-x-auto rounded-lg shadow">
            <div class="w-full whitespace-no-wrap">
                <div class="border-b bg-gray-50 text-left tracking-wide text-gray-500">
                    <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                        <InputLabel value="Datos de Conocimiento de Carga" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                        <form>
                            <div class="grid grid-cols-4 gap-4 mt-4">
                                <div>
                                    <InputLabel for="empresa" value="Planta Industrial"></InputLabel>
                                    <TextDisabled id="empresa" type="text" class="mt-2 block w-full"
                                    v-model="form.planta" autofocus disabled></TextDisabled>
                                </div>
                                <div>
                                    <InputLabel for="empresa" value="Empresa Transportista"/>
                                    <TextInput list="form.empresa" type="text" class="mt-2 block w-full" v-model="form.empresa"
                                    placeholder="Ej. Trans Huayana Kapac SRL."/>
                                    <datalist id="form.empresa" >
                                        <option v-for="conocimiento in conocimientos" :value="conocimiento.empresa "> {{ conocimiento.empresa }}</option>
                                    </datalist>
                                    <InputError :message="form.errors.empresa" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel for="conductor" value="Conductor"></InputLabel>
                                    <TextInput list="form.conductor" type="text" class="mt-2 block w-full"
                                    v-model="form.conductor" required
                                    placeholder="Ej. Dionicio Perez Quispe"></TextInput>
                                    <datalist id="form.conductor" >
                                        <option v-for="conocimiento in conocimientos" :value="conocimiento.conductor "> {{ conocimiento.conductor }}</option>
                                    </datalist>
                                    <InputError :message="form.errors.conductor" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel for="vehiculo" value="Vehiculo"></InputLabel>
                                    <TextInput list="form.vehiculo" type="text" class="mt-2 block w-full"
                                    v-model="form.vehiculo" required
                                    placeholder="Ej. Camion Tráiler Volvo Blanco"></TextInput>
                                    <datalist id="form.vehiculo" >
                                        <option v-for="conocimiento in conocimientos" :value="conocimiento.vehiculo "> {{ conocimiento.vehiculo }}</option>
                                    </datalist>
                                    <InputError :message="form.errors.vehiculo" class="mt-2"></InputError>
                                </div>
                            </div>
                            <div class="grid grid-cols-4 gap-4 mt-4">
                                <div>
                                    <InputLabel for="propietario" value="Propietario"></InputLabel>
                                    <TextInput list="form.propietario" type="text" class="mt-2 block w-full"
                                    v-model="form.propietario" autofocus required
                                    placeholder="Ej. Irenea Camacho Soliz"></TextInput>
                                    <datalist id="form.propietario" >
                                        <option v-for="conocimiento in conocimientos" :value="conocimiento.propietario "> {{ conocimiento.propietario }}</option>
                                    </datalist>
                                    <InputError :message="form.errors.propietario" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel for="licencia" value="Licencia"></InputLabel>
                                    <TextInput list="form.licencia" type="text" class="mt-2 block w-full"
                                    v-model="form.licencia" autofocus required
                                    placeholder="Ej. 8323421 LP"></TextInput>
                                    <datalist id="form.licencia" >
                                        <option v-for="conocimiento in conocimientos" :value="conocimiento.licencia "> {{ conocimiento.licencia }}</option>
                                    </datalist>
                                    <InputError :message="form.errors.licencia" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel for="placa" value="Placa"></InputLabel>
                                    <TextInput list="form.placa" type="text" class="mt-2 block w-full"
                                    v-model="form.placa" autofocus required
                                    placeholder="Ej. 123-PLP"></TextInput>
                                    <datalist id="form.placa" >
                                        <option v-for="conocimiento in conocimientos" :value="conocimiento.placa "> {{ conocimiento.placa }}</option>
                                    </datalist>
                                    <InputError :message="form.errors.placa" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel for="celular" value="Celular"></InputLabel>
                                    <TextInput list="form.celular" type="number" class="mt-2 block w-full"
                                    v-model="form.celular" autofocus required
                                    placeholder="Ej. 77373721"></TextInput>
                                    <datalist id="form.celular" >
                                        <option v-for="conocimiento in conocimientos" :value="conocimiento.celular "> {{ conocimiento.celular }}</option>
                                    </datalist>
                                    <InputError :message="form.errors.celular" class="mt-2"></InputError>
                                </div>
                            </div>
                            <br>
                            <SolicitudCarga :solicitudcarga="solicitudcarga" />
                            <br>
                            <CargaTable :cargas="cargas" :form="form"/>
                            <br>
                            <div class="-mx-3 px py-4" >
                                <div class="mx-3 py-2">
                                    <Link :href="route('solicitudcargas.index')"
                                    :class="'px-4 py-2 bg-gray-400 text-white border rounded-md font-semibold text-xs'">
                                    <i class="fa-solid fa-left-long" style="color: #ffffff;"></i> Volver
                                    </Link>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
