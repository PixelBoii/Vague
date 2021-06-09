<template>
    <div class="space-y-3">
        <div class="flex items-end justify-between">
            <div>
                <Label> Search </Label>
                <Input type="text" class="w-72" v-model="table.search" ref="search" tabindex="-1" @keydown.enter="refreshRecords()" />
            </div>

            <div class="flex items-center space-x-2 z-10">
                <PrimaryButton> Create New </PrimaryButton>

                <Menu as="div" class="relative inline-block text-left" v-if="actions.length > 0">
                    <div>
                        <MenuButton class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500">
                            Actions
                            <ChevronDownIcon class="-mr-1 ml-2 h-5 w-5" aria-hidden="true" />
                        </MenuButton>
                    </div>

                    <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                        <MenuItems class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                            <div class="py-1">
                                <MenuItem v-slot="{ active }" v-for="action in actions" :key="action.name">
                                    <div class="w-full px-4 py-2 text-sm text-gray-700 font-medium cursor-pointer" :class="{ 'bg-gray-100': active }" @click="dispatch(action.id)"> {{ action.name }} </div>
                                </MenuItem>
                            </div>
                        </MenuItems>
                    </transition>
                </Menu>
            </div>
        </div>

        <Table>
            <template v-slot:thead>
                <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Select</span>
                </th>

                <th scope="col" v-for="field in fields" :key="`field-${field.column}`" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" @click="handleSortClick(field.column)">
                    <div class="flex items-center space-x-2">
                        <span> {{ field.name }} </span>

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" :class="{'transform rotate-180': table.order == 'ASC'}" fill="none" viewBox="0 0 24 24" stroke="currentColor" v-if="field.column == table.sortBy">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </th>

                <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Edit</span>
                </th>
            </template>

            <template v-slot:tbody>
                <tr v-for="record in records.data" :key="record.id" class="hover:bg-gray-50 transition duration-75">
                    <td class="whitespace-nowrap pl-6 pr-3 py-4" @click="record.selected = !record.selected">
                        <CheckCircleIcon class="stroke-current h-6 w-6" :class="[record.selected ? 'text-green-500' : 'text-gray-400']" />
                    </td>

                    <td v-for="field in record.fields" :key="`record-${record.data.id}-${field.column}`" class="whitespace-nowrap">
                        <inertia-link :href="`/vague/resource/${slug}/${record.data.id}`" class="inline-block h-full">
                            <div class="px-6 py-4 h-full">
                                <ResourceBuilder :element="field.element" v-if="field.casts == 'relationship'" />

                                <span class="text-sm font-medium text-gray-900" v-else> {{ record.data[field.column] }} </span>
                            </div>
                        </inertia-link>
                    </td>

                    <td class="whitespace-nowrap text-sm font-medium">
                        <inertia-link :href="`/vague/resource/${slug}/${record.data.id}`">
                            <div class="px-6 py-4 text-gray-400 flex items-center justify-end">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="w-6 h-6 fill-current">
                                    <polygon points="12.95 10.707 13.657 10 8 4.343 6.586 5.757 10.828 10 6.586 14.243 8 15.657 12.95 10.707"></polygon>
                                </svg>
                            </div>
                        </inertia-link>
                    </td>
                </tr>
            </template>
        </Table>

        <Pagination :links="records.links" />
    </div>
</template>

<script>
import Table from './Table';
import Pagination from './Pagination';
import PrimaryButton from '../Components/PrimaryButton';
import Input from '../Components/Input';
import Label from '../Components/Label';

import CheckCircleIcon from '@heroicons/vue/outline/CheckCircleIcon';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import { ChevronDownIcon } from '@heroicons/vue/solid';
import debounce from 'lodash/debounce';
import pickBy from 'lodash/pickBy';

export default {
    props: [
        'fields',
        'actions',
        'records',
        'slug',
        'filters'
    ],
    data() {
        return {
            table: {
                search: this.filters.search,
                sortBy: this.filters.sortBy,
                order: this.filters.order
            }
        }
    },
    components: {
        Table,
        Pagination,
        PrimaryButton,
        Input,
        Label,

        CheckCircleIcon,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        ChevronDownIcon,
    },
    watch: {
        table: {
            deep: true,
            handler: debounce(function(data) {
                this.refreshRecords(data);
            }, 350)
        }
    },
    mounted() {
        this.$refs.search.$el.focus();
    },
    methods: {
        handleSortClick(column) {
            var data = {
                ...this.table,
                sortBy: column,
                order: this.table.order == 'DESC' ? 'ASC' : 'DESC'
            };

            if (this.table.order == 'ASC' && this.table.sortBy == column) {
                data.sortBy = null;
                data.order = 'ASC';
            }

            this.table = data;
        },
        dispatch(action) {
            this.$inertia.post(`${window.location.pathname}/${action}`, {
                records: this.records.data.filter(e => e.selected).map(e => e.id)
            });
        },
        refreshRecords(data = null) {
            if (!data) {
                data = this.table;
            }

            this.$inertia.get(window.location.pathname, pickBy(data), { preserveState: true, preserveScroll: true });
        }
    }
}
</script>
