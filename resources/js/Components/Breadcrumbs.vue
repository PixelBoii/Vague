<template>
    <div class="font-semibold flex items-center space-x-2 text-gray-500">
        <template v-for="(item, i) in items" :key="`item-${i}`">
            <inertia-link :href="item.href">
                <span :class="i + 1 == items.length ? 'text-gray-600' : 'font-medium'"> {{ item.name }} </span>
            </inertia-link>

            <ChevronRightIcon class="h-5 w-5 fill-current" v-if="i + 1 < items.length" />
        </template>
    </div>
</template>

<script>
import { ChevronRightIcon } from '@heroicons/vue/solid';

export default {
    props: [
        'items'
    ],
    components: {
        ChevronRightIcon
    }
}
</script>
