<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" static class="fixed z-10 inset-0 overflow-y-auto" @close="open = false" :open="open">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                </TransitionChild>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-4 pb-4 sm:p-6">
                            <div class="border-b border-gray-300 w-full flex items-center space-x-2 text-gray-700 mb-6">
                                <SearchIcon class="h-6 w-6 fill-current" />
                                <input type="text" placeholder="Search.." class="w-full h-14 p-3 border-none rounded-md bg-transparent" v-model="search">
                            </div>

                            <div class="w-full overflow-y-auto quick-search-results space-y-6">
                                <div v-if="quickSearch.length == 0">
                                    <span class="text-gray-700 font-medium"> No results found </span>
                                </div>

                                <div class="space-y-2" v-for="resource in quickSearch" :key="resource.name">
                                    <p class="font-semibold text-gray-700"> {{ resource.name }} </p>

                                    <div class="rounded-md overflow-hidden border border-gray-300">
                                        <inertia-link @click="open = false" class="bg-white w-full p-3 flex items-center justify-between cursor-pointer" :class="{'border-t border-gray-300': i > 0}" :href="`/vague/resource/${resource.slug}/${record.id}`" v-for="(record, i) in resource.records" :key="record.id">
                                            <ResourceBuilder :element="record.summary" />

                                            <div>
                                                <ChevronRightIcon class="h-5 w-5 fill-current" />
                                            </div>
                                        </inertia-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>

    <div>
        <button class="flex items-center space-x-3 text-gray-700 h-16 w-96 px-6 focus:outline-none" @click="open = true">
            <span> Quick Search.. </span>

            <div class="border border-gray-400 p-1 text-xs rounded-md flex items-center justify-center font-medium text-gray-500">
                <span> CTRL </span>

                <PlusIcon class="h-4 w-4" />

                <span> K </span>
            </div>
        </button>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
import PlusIcon from '@heroicons/vue/solid/PlusIcon';
import SearchIcon from '@heroicons/vue/solid/SearchIcon';
import ChevronRightIcon from '@heroicons/vue/solid/ChevronRightIcon';
import { Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'

export default {
    components: {
        PlusIcon,
        SearchIcon,
        ChevronRightIcon,
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
    },
    data() {
        return {
            open: false,
            search: ''
        }
    },
    computed: {
        quickSearch() {
            return this.$page.props.quickSearch?.results;
        }
    },
    watch: {
        search: function(search) {
            Inertia.reload({
                data: {
                    quickSearch: search
                }
            });
        }
    },
    mounted() {
        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey && e.code == 'KeyK') {
                e.preventDefault();

                this.open = true;
            }
        });
    }
}
</script>

<style scoped>
.quick-search-results {
    max-height: 50vh;
}
</style>