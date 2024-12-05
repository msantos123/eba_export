<template>
    <div>
      <textarea
        v-model="internalValue"
        @input="onInput"
        class="mt-2 block w-full border rounded resize-none bg-gray-200 text-gray-700"
        rows="1"
        ref="textarea"
        disabled
      ></textarea>
    </div>
  </template>

  <script setup>
  import { ref, watch, defineProps, toRefs, onMounted, defineEmits  } from 'vue';

  const props = defineProps({
    modelValue: {
      type: String,
      default: '',
    },
  });

  const emit = defineEmits();
  const { modelValue } = toRefs(props);
  const internalValue = ref(modelValue.value);
  const textarea = ref(null);

  // Emitir el cambio al componente padre
    const emitInput = () => {
    emit('update:modelValue', internalValue.value);
    };

  // Función para ajustar la altura del textarea
  const adjustHeight = () => {
    textarea.value.style.height = 'auto'; // Restablecer la altura para calcular
    textarea.value.style.height = textarea.value.scrollHeight + 'px'; // Ajustar a la altura del contenido
  };

  // Manejar el input
const onInput = (event) => {
  internalValue.value = event.target.value;  // Actualizar el valor interno
  emitInput();  // Emitir el cambio hacia el padre
  adjustHeight();  // Ajustar la altura
};

// Ajustar la altura al cargar el componente y al cambiar el valor
watch(modelValue, (newValue) => {
  internalValue.value = newValue;  // Sincronizar el valor interno
  adjustHeight();
});

  onMounted(() => {
    adjustHeight();
  });
  </script>

<style scoped>
/* Estilos opcionales */
textarea:disabled {
  background-color: #e5e7eb; /* Color de fondo más oscuro */
  color: #4b5563; /* Color de texto más oscuro */
  opacity: 1; /* Asegura que el fondo no se vea más claro */
}
</style>
