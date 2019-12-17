<template>
    <div id = "app">
        <navigation></navigation>
        <router-view></router-view>
    </div>
</template>
<script>
import Navigation from './NaviComponent.vue'
    export default {
        components: {
            'navigation' : Navigation
        }
    }
</script>
