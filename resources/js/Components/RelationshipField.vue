<template>
    <Listbox as="div" class="relative" v-model="selected" @click="records.length == 0 && refreshRecords()">
        <ListboxButton class="relative w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <ResourceBuilder :element="selected ? selected.element : field.element" v-if="selected ? selected.element : field.element" />
            <span v-else> Select </span>

            <span class="ml-3 absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
            </span>
        </ListboxButton>

        <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <ListboxOptions class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-72 rounded-md pb-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                <div class="p-1 z-10 sticky top-0">
                    <Input type="text" v-model="search" class="w-full" />
                </div>

                <ListboxOption as="template" v-for="(record, i) in records" :key="i" :value="record" v-slot="{ active, selected }">
                    <li :class="[active || selected ? 'bg-gray-100' : 'bg-white', 'cursor-default select-none relative py-2 px-3']">
                        <ResourceBuilder :element="record.element" />
                    </li>
                </ListboxOption>
            </ListboxOptions>
        </transition>
    </Listbox>
</template>

<script> 
import axios from 'axios';
import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'
import { CheckIcon, SelectorIcon } from '@heroicons/vue/solid'

export default {
    props: [
        'field'
    ],
    data() {
        return {
            search: '',
            records: [],
            selected: null
        }
    },
    components: {
        Listbox,
        ListboxButton,
        ListboxLabel,
        ListboxOption,
        ListboxOptions,

        CheckIcon,
        SelectorIcon,
    },
    methods: {
        async refreshRecords() {
            this.records = (await axios.post(`/vague/resource/${this.field.relationship.target.slug}/search`, {
                'search': this.search
            })).data;
        }
    },
    watch: {
        search: 'refreshRecords',
        selected(value) {
            this.$emit('update:modelValue', value.data[this.field.relationship.ownerKey]);
        }
    }
}
</script>

<style>

</style>