<template>
    <div>
        <InputLabel value="Busqueda de Contenedor" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
        <div id="ordertracker-widget"></div>
    </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { ref } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';

const trackingInfo = ref({});

onMounted(() => {
    // Cargar el script del widget
    const script = document.createElement('script');
    script.src = 'https://www.ordertracker.com/sdk.js';
    script.async = true;
    script.onload = () => {
        console.log('Ordertracker script loaded'); // Verifica que el script se cargue
        if (typeof Ordertracker === 'undefined') {
            console.error('Ordertracker is not defined');
            return;
        }
        Ordertracker({
            id: "670e6ee49e0a4b036d860883",
             // Usar una función separada para manejar la actualización

            // Uncomment and replace YOUR_TRACKING_NUMBER if needed
            // trackingNumber: "YOUR_TRACKING_NUMBER"
        }).render('#ordertracker-widget');
    };
    document.body.appendChild(script);
});

// Función para manejar la actualización de datos
const handleTrackingUpdate = (data) => {
    console.log('Tracking data received:', data); // Verifica que recibas datos
    trackingInfo.value = data; // Guarda la información recibida
    //saveTrackingInfo(data); // Llama a la función para guardar la información
};
</script>

<style>
/* Agrega tu estilo aquí si es necesario */
</style>
