<template>
    <button :type="type" class="inline-block rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-400 text-sm">
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
