<template>
    <div class="px-8 py-6">
        <div class="mb-2">
            <p class="text-lg font-medium"> Resources </p>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-4 lg:grid-cols-2 w-full gap-6">
            <ResourceCard v-for="resource in resources" :key="resource.name" :resource="resource" />
        </div>
    </div>
</template>

<script>
import ResourceCard from '../Components/ResourceCard.vue';

export default {
    components: {
        ResourceCard
    },
    props: [
        'resources'
    ]
}
</script>