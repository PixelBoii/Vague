<template>
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <slot name="description"></slot>
            </div>
        </div>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <slot name="form"></slot>
        </div>
    </div>
</template>
