<template>
    <Listbox as="div" class="relative" :modelValue="modelValue" @update:modelValue="(e) => $emit('update:modelValue', e)">
        <ListboxButton class="relative w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <ResourceBuilder v-if="modelValue" :element="modelValue.element" />

            <p v-else> Select </p>
        </ListboxButton>

        <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <ListboxOptions class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-56 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                <ListboxOption as="template" v-for="(option, i) in options" :key="`option-${i}`" :value="option" v-slot="{ active }">
                    <li as="template" :class="[active ? 'text-white bg-indigo-600' : 'text-gray-900', 'cursor-default select-none relative py-2 pl-3 pr-9']">
                        <ResourceBuilder :element="option.element" />
                    </li>
                </ListboxOption>
            </ListboxOptions>
        </transition>
    </Listbox>
</template>

<script>
import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'

export default {
    components: {
        Listbox,
        ListboxButton,
        ListboxLabel,
        ListboxOption,
        ListboxOptions
    },
    props: [
        'modelValue',
        'options'
    ]
}
</script>
