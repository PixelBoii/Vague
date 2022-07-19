<template>
    <div class="space-y-1">
        <Label> {{ field.name }} </Label>

        <div class="flex items-center space-x-2" v-if="field.casts == 'image'">
            <img :src="value" class="h-8 w-8 rounded-full">

            <Input type="text" class="w-full" :modelValue="value" @update:modelValue="handle" />
        </div>

        <Listbox as="div" :modelValue="value" @update:modelValue="handle" class="relative" v-else-if="field.casts == 'select'">
            <ListboxButton class="relative w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <span class="block truncate"> {{ value ?? 'Select' }} </span>

                <span class="ml-3 absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                </span>
            </ListboxButton>

            <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                <ListboxOptions class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-56 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                    <ListboxOption as="template" v-for="option in field.options" :key="option.name" :value="option.name" v-slot="{ active, selected }">
                        <li :class="[active ? 'text-white bg-indigo-600' : 'text-gray-900', 'cursor-default select-none relative py-2 pl-3 pr-9']">
                            <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']"> {{ option.alias ?? option.name }} </span>

                            <span v-if="selected" :class="[active ? 'text-white' : 'text-indigo-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                                <CheckIcon class="h-5 w-5" aria-hidden="true" />
                            </span>
                        </li>
                    </ListboxOption>
                </ListboxOptions>
            </transition>
        </Listbox>

        <RelationshipField @update:modelValue="handle" :field="field" v-else-if="field.casts == 'relationship'" />

        <Input :type="field.casts" :step="0.01" :modelValue="value" @update:modelValue="handle" class="w-full" :disabled="!field.fillable" v-else />
    </div>
</template>

<script>
import Input from './Input.vue';
import Label from './Label.vue';
import RelationshipField from './RelationshipField.vue';

import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'
import { CheckIcon, SelectorIcon } from '@heroicons/vue/solid'

export default {
    props: [
        'field',
        'modelValue'
    ],
    computed: {
        value() {
            if (this.field.casts == 'date' || this.field.casts == 'datetime-local') {
                var date = new Date(this.modelValue);

                date.setSeconds(0, 0);

                return date.toISOString().substring(0, date.toISOString().length - 1);
            }

            if (this.field.casts == 'select') {
                var option = this.field.options.find(e => e.name == this.modelValue);

                return option?.alias ?? option?.name;
            }

            return this.modelValue;
        }
    },
    emits: ['update:modelValue'],
    methods: {
        handle(value) {
            this.$emit('update:modelValue', value);
        }
    },
    components: {
        Input,
        Label,
        RelationshipField,

        Listbox,
        ListboxButton,
        ListboxLabel,
        ListboxOption,
        ListboxOptions,

        CheckIcon,
        SelectorIcon,
    }
}
</script>
