<template>
    <form @submit.prevent>
        <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="px-4 py-5 bg-white sm:p-6">
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

            <div class="px-4 py-3 sm:px-6 bg-gray-50 flex items-center justify-between">
                <TrashIcon class="h-5 w-5 stroke-current text-red-500 cursor-pointer" @click="post('delete')" />

                <div class="flex items-center space-x-2">
                    <ResourceBuilder :element="action.element" v-for="action in actions" :key="action.name" @click="post(action.id)" />

                    <PrimaryButton @click="post('save')"> Save </PrimaryButton>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import { useForm } from '@inertiajs/inertia-vue3';
import EditField from '../Components/EditField';
import TrashIcon from '@heroicons/vue/outline/TrashIcon';

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

        return { form, post }
    },
    components: {
        EditField,

        TrashIcon,
    }
}
</script>
