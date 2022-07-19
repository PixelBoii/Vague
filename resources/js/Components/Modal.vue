<template>
    <TransitionRoot as="template" :show="show">
        <Dialog as="div" static class="fixed z-10 inset-0 overflow-y-auto" @close="$emit('update:show', false)" :open="show">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                </TransitionChild>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div class="inline-block align-bottom bg-white rounded-lg overflow-hidden text-left shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" :class="maxWidthClasses[width]">
                        <div class="bg-white px-7 pt-8 pb-8 sm:flex sm:items-start space-x-4">
                            <slot name="body">
                                <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                    <slot name="content">
                                        <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">
                                            {{ title }}
                                        </DialogTitle>

                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500"> {{ description }} </p>
                                        </div>
                                    </slot>
                                </div>
                            </slot>
                        </div>

                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse" v-if="enabledSlots.includes('footer')">
                            <slot name="footer">
                                <PrimaryButton @click="$emit('submit')"> Submit </PrimaryButton>
                            </slot>
                        </div>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import { Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';

export default {
    props: {
        title: {
            type: String
        },
        description: {
            type: String
        },
        show: {
            type: Boolean
        },
        width: {
            type: String,
            default: 'lg'
        },
        enabledSlots: {
            type: Array,
            default: ['body', 'content', 'footer']
        }
    },
    emits: ['update:show'],
    components: {
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
    },
    data() {
        return {
            maxWidthClasses: {
                sm: 'sm:max-w-sm',
                md: 'sm:max-w-md',
                lg: 'sm:max-w-lg',
                xl: 'sm:max-w-xl'
            }
        };
    },
}
</script>