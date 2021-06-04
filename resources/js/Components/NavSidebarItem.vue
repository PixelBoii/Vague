<template>
    <inertia-link :href="link">
        <div class="bg-gray-900 rounded-lg p-3 text-gray-300 font-semibold flex items-center space-x-2">
            <slot />
        </div>
    </inertia-link>
</template>

<script>
export default {
    props: {
        link: {
            required: true,
            type: String
        }
    }
}
</script>