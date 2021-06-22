<template>
    <Modal v-model:show="modals.delete.show">
        <template #body>
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                <ExclamationIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
            </div>

            <div>
                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Delete Record </DialogTitle>

                <div class="mt-2">
                    <p class="text-sm text-gray-500"> Are you sure you want to delete this record? </p>
                </div>
            </div>
        </template>

        <template #footer>
            <DangerousButton @click="post('delete')"> Delete </DangerousButton>
        </template>
    </Modal>

    <form @submit.prevent v-bind="$attrs">
        <div class="shadow sm:rounded-md">
            <div class="px-4 py-5 bg-white rounded-t-md sm:p-6">
                <div class="grid grid-cols-12 gap-6">
                    <EditField
                        v-model="form[field.column]"
                        :field="field"
                        v-for="field in fields"
                        :key="field.column"
                        :style="`grid-column: span ${field.columnSpan ?? 6} / span ${field.columnSpan ?? 6}`"
                    />
                </div>
            </div>

            <div class="px-4 py-3 sm:px-6 bg-gray-50 rounded-b-md flex items-center justify-between">
                <TrashIcon class="h-5 w-5 stroke-current text-red-500 cursor-pointer" @click="modals.delete.show = true" />

                <div class="flex items-center space-x-2">
                    <ResourceAction :action="action" v-for="action in actions" :key="action.name" @perform="post(action.id)" />

                    <PrimaryButton @click="post('save')"> Save </PrimaryButton>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import { reactive } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { DialogTitle } from '@headlessui/vue';
import { ExclamationIcon, TrashIcon } from '@heroicons/vue/outline';

import EditField from './EditField';
import ResourceAction from './ResourceAction';
import Modal from './Modal.vue';

export default {
    props: [
        'record',
        'fields',
        'actions'
    ],
    setup (props) {
        const form = useForm(
            props.fields.reduce((form, field) => {
                form[field.column] = props.record[field.column];

                return form;
            }, {})
        )

        const post = (action) => {
            form.post(`${window.location.href}/${action}`);
        }

        const modals = reactive({
            delete: {
                show: false
            }
        })

        return { form, post, modals }
    },
    components: {
        EditField,
        ResourceAction,
        Modal,

        TrashIcon,
        ExclamationIcon,
        DialogTitle
    }
}
</script>
