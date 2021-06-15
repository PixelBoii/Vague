<template>
    <Modal v-model:show="open">
        <template #content>
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
        </template>

        <template #footer>
        </template>
    </Modal>

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
import { PlusIcon, SearchIcon, ChevronRightIcon } from '@heroicons/vue/solid';
import Modal from './Modal.vue';

export default {
    components: {
        PlusIcon,
        SearchIcon,
        ChevronRightIcon,

        Modal,
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