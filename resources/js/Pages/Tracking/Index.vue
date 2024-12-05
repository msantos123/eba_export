<script setup>
import BlueButton from '@/Components/BlueButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import OrderTracker from '@/Components/OrderTracker.vue';
import OrderTrackerSalida from '@/Components/OrderTrackerSalida.vue';
import { ref } from 'vue';

const props = defineProps({
    comprobanteSalidas: {
        type: Object,
    }
});

const currentComponent = ref('');

const showTracker = () => {
    currentComponent.value = 'tracker';
};
</script>

<template>
    <Head title="Tracking" />
    <AuthenticatedLayout>
        <template #header>
            Tracking
        </template>

        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="px-4 py-3 flex">
                <div class="mx-1">
                    <a
                        href="https://www.msc.com/en/track-a-shipment"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-block rounded-md bg-yellow-500 px-4 py-2 text-white hover:bg-yellow-400 text-sm">
                        <i class="fa-solid fa-globe" style="color: #ffffff;"></i> MSC
                    </a>
                </div>
                <div class="mx-1">
                    <BlueButton @click="showTracker"
                    class="inline-block rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-400">
                            <i class="fa-solid fa-eye" style="color: #ffffff;"></i> Buscar un Contenedor
                    </BlueButton>
                </div>
            </div>
        </div>

    <div class="min-w-full overflow-x-auto rounded-lg shadow">
        <div class="w-full whitespace-no-wrap">
            <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                        <div v-if="currentComponent === 'tracker'">
                            <OrderTracker />
                        </div>
                        <br>
                        <div>
                            <OrderTrackerSalida :comprobanteSalidas = "comprobanteSalidas"/>
                        </div>
                </div>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
