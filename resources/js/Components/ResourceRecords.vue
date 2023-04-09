<template>
    <Modal v-model:show="modals.create.show" width="xl" @submit="post('create')">
        <template #content>
            <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Create Record </DialogTitle>

            <div class="mt-2 grid grid-cols-12 gap-6">
                <EditField
                    v-model="form[field.column]"
                    v-for="field in fillableFields"
                    :field="field"
                    :key="field.column"
                    :style="`grid-column: span ${field.columnSpan ?? 6} / span ${field.columnSpan ?? 6}`"
                />
            </div>
        </template>
    </Modal>

    <div class="space-y-3" v-bind="$attrs">
        <div class="flex items-end justify-between">
            <div>
                <Label> Search </Label>
                <Input type="text" class="w-72" v-model="table.search" ref="search" tabindex="-1" @keydown.enter="refreshRecords()" />
            </div>

            <div class="flex items-center space-x-2 z-10">
                <PrimaryButton @click="modals.create.show = true"> Create New </PrimaryButton>

                <Menu as="div" class="relative inline-block text-left" v-if="actions?.length > 0">
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
                    <CheckCircleIcon class="stroke-current h-6 w-6" :class="[records.data.every(e => e.selected) ? 'text-green-500' : 'text-gray-400']" @click="toggleSelectAll" />
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
                                <ResourceBuilder :element="field.element" />
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
import Table from './Table.vue';
import Pagination from './Pagination.vue';
import Modal from './Modal.vue';
import PrimaryButton from './PrimaryButton.vue';
import Input from './Input.vue';
import Label from './Label.vue';
import EditField from './EditField.vue';

import CheckCircleIcon from '@heroicons/vue/outline/CheckCircleIcon';
import { Menu, MenuButton, MenuItem, MenuItems, DialogTitle } from '@headlessui/vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ChevronDownIcon } from '@heroicons/vue/solid';
import { debounce, pickBy } from 'lodash';

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
            },
            modals: {
                create: {
                    show: false
                }
            }
        }
    },
    setup(props) {
        const form = useForm(
            props.fields.reduce((form, field) => {
                if (field.fillable) {
                    form[field.column] = null;
                }

                return form;
            }, {})
        )

        return { form }
    },
    computed: {
        fillableFields() {
            return this.fields.filter(e => e.fillable);
        },
        config() {
            return usePage().props.config;
        }
    },
    components: {
        Table,
        Pagination,
        Modal,
        PrimaryButton,
        Input,
        Label,
        EditField,

        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        DialogTitle,

        ChevronDownIcon,
        CheckCircleIcon,
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
            this.$inertia.post(`${window.location.pathname}/actions/${action}`, {
                records: this.records.data.filter(e => e.selected).map(e => e.data.id)
            });
        },
        refreshRecords(data = null) {
            if (!data) {
                data = this.table;
            }

            this.$inertia.get(window.location.pathname, pickBy(data), { preserveState: true, preserveScroll: true });
        },
        post(action) {
            this.form.post(`/${this.config.prefix}/resource/${this.slug}/actions/${action}`);
        },
        toggleSelectAll() {
            if (this.records.data.every(record => record.selected)) {
                this.records.data = this.records.data.map(record => {
                    record.selected = false;
                    return record;
                });
            } else {
                this.records.data = this.records.data.map(record => {
                    record.selected = true;
                    return record;
                });
            }
        }
    }
}
</script>
