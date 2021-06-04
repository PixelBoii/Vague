<template>
    <component :is="element.tag" v-bind="element.attributes">
        <template v-if="Array.isArray(element.content)">
            <ResourceBuilder :element="el" v-for="(el, i) in element.content" :key="i" />
        </template>

        <template v-else> {{ element.content }} </template>
    </component>
</template>

<script>
import RecordForm from './RecordForm';
import ResourceRecords from './ResourceRecords';

export default {
    name: 'ResourceBuilder',
    props: [
        'element'
    ],
    components: {
        RecordForm,
        ResourceRecords,
    }
}
</script>
