<template>
    <input class="focus:ring-indigo-500 focus:border-indigo-500 block sm:text-sm border-gray-300 rounded-md" @input="handle" :value="modelValue" />
</template>

<script>
export default {
    props: [
        'modelValue'
    ],
    emits: ['update:modelValue'],
    methods: {
        handle(event) {
            this.$emit('update:modelValue', event.target.value);
        }
    }
}
</script>