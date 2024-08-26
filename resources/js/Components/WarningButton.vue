<script setup>
defineProps({
    type:{
        type: String,
        default: 'submit',
    }
})
</script>
<template>
    <button
        class="inline-block rounded-md bg-red-600 px-4 py-2 text-white hover:bg-red-500 text-sm"
    >
        <slot />
    </button>
</template>
