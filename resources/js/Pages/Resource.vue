<template>
    <div>
        <div class="bg-gray-200 px-10 py-10 flex items-center justify-between">
            <div class="space-y-2">
                <p class="text-gray-700 font-bold text-3xl"> {{ resource.name }} Resource </p>

                <div class="flex">
                    <div class="flex items-center text-gray-500 space-x-1">
                        <DatabaseIcon class="h-5 w-5 stroke-current" />
                        <p class="font-medium"> {{ records.total }} records </p>
                    </div>
                </div>
            </div>

            <div class="flex items-center -space-x-3">
                <img :src="user.icon" v-for="user in users_with_access" :key="user.id" class="rounded-full h-9 w-9">
            </div>
        </div>

        <div class="px-8 py-8">
            <ResourceRecords :records="records" :fields="fields" :actions="actions" :slug="resource.slug" :filters="filters" />
        </div>
    </div>
</template>

<script>
import ResourceRecords from '../Components/ResourceRecords';
import DatabaseIcon from '@heroicons/vue/outline/DatabaseIcon';

export default {
    props: [
        'records',
        'resource',
        'fields',
        'actions',
        'filters',
        'users_with_access'
    ],
    components: {
        ResourceRecords,

        DatabaseIcon
    }
}
</script>