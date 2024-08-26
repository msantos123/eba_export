<template>
    <input class="block mt-1 w-full rounded-md form-input focus:border-indigo-600 bg-gray-200 text-gray-500" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="input">
</template>

<script setup>
import { onMounted, ref } from 'vue';

defineProps(['modelValue']);

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});
</script>
