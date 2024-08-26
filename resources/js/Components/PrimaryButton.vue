<template>
    <button :type="type" class="inline-block rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-500 text-sm">
        <slot />
    </button>
</template>

<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>
