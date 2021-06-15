<template>
    <Modal v-model:show="modal" v-if="action.confirmation">
        <template #body>
            <ResourceBuilder :element="action.modal.body" />
        </template>

        <template #footer>
            <PrimaryButton @click="$emit('perform')"> Confirm </PrimaryButton>
        </template>
    </Modal>

    <ResourceBuilder :element="action.element" @click="action.confirmation ? modal = true : $emit('perform')" />
</template>

<script>
import Modal from './Modal.vue';

export default {
    data() {
        return {
            modal: false
        }
    },
    components: {
        Modal
    },
    props: [
        'action'
    ],
    emits: [
        'perform'
    ]
}
</script>
