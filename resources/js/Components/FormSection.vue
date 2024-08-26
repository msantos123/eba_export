<script setup>
import { computed, useSlots } from 'vue';
import SectionTitle from './SectionTitle.vue';

defineEmits(['submitted']);

const hasActions = computed(() => !! useSlots().actions);
</script>

<template>
    <div>
        <SectionTitle>
            <template #title>
               <h1><slot name="title" /></h1>
            </template>
        </SectionTitle>

        <div>
            <form @submit.prevent="$emit('submitted')">
                <div

                    :class="hasActions ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md'"
                >
                    <div >
                        <slot name="form" />
                    </div>
                </div>

                <div v-if="hasActions" >
                    <slot name="actions" />
                </div>
            </form>
        </div>
    </div>
</template>
