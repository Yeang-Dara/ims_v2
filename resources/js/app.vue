<template>
    <div>
       <!-- <template v-if="!$route.meta.allowAnonymous">
            <maintemplate/>
            <hr-maintemplate/>
        </template>
        <template v-else>
            <router-view></router-view>
        </template> -->
        <router-view></router-view>
    </div>
</template>

<script>

export default {
    name: 'app',
    data() {
        return {
        drawer: true
        }
    }
}
</script>

<style>
  .v-btn:hover:before{
    color: transparent !important;
  }
</style>
