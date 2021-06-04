<template>
    <div>
        <div class="bg-gray-100 border-b border-gray-300 px-6 h-14 flex items-center sticky top-0 z-10">
            <Breadcrumbs :items="breadcrumbs.items" />
        </div>

        <div class="px-8 py-4 space-y-4">
            <ResourceRecords :records="records" :fields="fields" :actions="actions" :slug="slug" :filters="filters" />
        </div>
    </div>
</template>

<script>
import ResourceRecords from '../Components/ResourceRecords';
import Breadcrumbs from '../Components/Breadcrumbs';

export default {
    props: [
        'records',
        'slug',
        'name',
        'fields',
        'actions',
        'filters',
        'breadcrumbs'
    ],
    components: {
        ResourceRecords,
        Breadcrumbs
    }
}
</script>