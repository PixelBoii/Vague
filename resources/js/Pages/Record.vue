<template>
    <div>
        <div class="bg-gray-100 border-b border-gray-300 px-6 h-14 flex items-center sticky top-0 z-10">
            <Breadcrumbs :items="breadcrumbs.items" />
        </div>

        <div class="px-8 py-6">
            <ResourceBuilder :element="elements" />
        </div>
    </div>
</template>

<script>
import Breadcrumbs from '../Components/Breadcrumbs.vue';

export default {
    props: [
        'elements',
        'record',
        'breadcrumbs'
    ],
    components: {
        Breadcrumbs
    }
}
</script>

<style>

</style>