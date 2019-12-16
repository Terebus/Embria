<template>
    <div>
        <h2>Dashboard</h2>
        <ul class="nav">
            <li class="nav-item">
                <router-link :to="{name:'dashboard.news'}" class="nav-link">News</router-link>
            </li>
            <li class="nav-item">
                <router-link :to="{name:'dashboard.photos'}" class="nav-link">Photos</router-link>
            </li>
        </ul>
        <transition name="slide">
        <router-view></router-view>
        </transition>
    </div>
</template>

<script>
    export default {}
</script>

<style scoped>

</style>
