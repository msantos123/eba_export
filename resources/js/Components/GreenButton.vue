<template>
    <button :type="type" class="inline-block rounded-md bg-green-500 px-4 py-2 text-white hover:bg-green-400 text-sm">
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
