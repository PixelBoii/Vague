<template>
    <div class="bg-gray-800 w-80 h-screen fixed top-0 left-0 flex flex-col justify-between">
        <div>
            <inertia-link href="/vague">
                <div class="bg-gray-900 h-14 flex items-center px-4">
                    <p class="text-white font-semibold"> {{ config.app_name }} </p>
                </div>
            </inertia-link>

            <div class="space-y-2 p-3">
                <NavSidebarItem link="/vague">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                    </svg>

                    <span> Resources </span>
                </NavSidebarItem>
            </div>
        </div>

        <div class="border-t border-gray-700 p-4 flex items-center space-x-4">
            <inertia-link :href="`/${config.prefix}/resource/user/${user.id}`">
                <ResourceBuilder :element="user_summary" />
            </inertia-link>
        </div>
    </div>
</template>

<script>
import NavSidebarItem from '../Components/NavSidebarItem.vue';
import { usePage } from '@inertiajs/inertia-vue3'

export default {
    components: {
        NavSidebarItem
    },
    computed: {
        user() {
            return usePage().props.value.auth.user;
        },
        user_summary() {
            return usePage().props.value.auth.summary;
        },
        config() {
            return usePage().props.value.config;
        }
    }
}
</script>

<style>

</style>