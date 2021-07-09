<template>
    <div class="rounded-md shadow-md overflow-hidden">
        <div class="bg-white px-6 py-4" v-for="(el, i) in elements" :key="i">
            <ResourceBuilder :element="el" />
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'elements'
    ]
}
</script>
