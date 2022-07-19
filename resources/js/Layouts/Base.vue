<template>
    <div>
        <NavSidebar />

        <div class="w-full pl-80">
            <NavBar />

            <slot />
        </div>
    </div>
</template>

<script>
import NavBar from '../Components/NavBar.vue';
import NavSidebar from '../Components/NavSidebar.vue';

export default {
    components: {
        NavBar,
        NavSidebar
    }
}
</script>