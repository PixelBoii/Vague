<template>
    <div class="rounded-lg bg-white border border-gray-200 shadow-sm overflow-hidden">
        <div class="w-full px-5 py-5 bg-gradient-to-tr" :class="`from-${color}-50 to-${color}-100`">
            <p class="text-gray-900 font-semibold"> {{ resource.name }} </p>
            <p class="text-gray-600 font-medium text-sm"> {{ resource.record_count }} records </p>
        </div>

        <inertia-link :href="`/vague/resource/${resource.slug}`">
            <div class="border-t border-gray-100 text-gray-700 text-sm p-3 text-center font-medium hover:bg-gray-100 transition cursor-pointer"> More Details.. </div>
        </inertia-link>
    </div>
</template>

<script>
export default {
    props: [
        'resource'
    ],
    data() {
        return {
            colors: ['red', 'blue', 'indigo', 'green', 'purple']
        }
    },
    computed: {
        color() {
            return this.randomColor();
        }
    },
    methods: {
        randomColor() {
            return this.colors[Math.round((this.colors.length - 1) * Math.random())];
        }
    }
}
</script>