<template>
    <div class="flex items-center">
        <div v-for="(link, i) in links" :key="i">
            <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm border rounded text-grey" :class="{ 'ml-auto': link.label === 'Next' }"> {{ link.label }} </div>
            <inertia-link v-else class="mr-1 mb-1 px-4 py-3 text-sm border rounded hover:bg-white focus:border-indigo focus:text-indigo" :class="{ 'bg-white': link.active, 'ml-auto': link.label === 'Next' }" :href="link.url"> {{ link.label }} </inertia-link>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        links: Array,
    },
}
</script>