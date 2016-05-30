<template>
  <div class="breadcrumb-wrapper">
    <h4 class="mainTitle no-margin"><i class="fa"v-bind:class="'fa-'+currentRoute.icon"></i> {{currentRoute.name}}</h4>
  </div>
</template>

<script>
    import * as utils from '../utils'
    import store from '../vuex/store'
    export default {
        computed: {
            currentRoute () {
                var current = window.location.href
                var result = current.replace(/^\/|\/$/g, '');
                var menuList = store.state.userInfo.items.menu
                return utils.selectFromJson(menuList, 'url', result)
            }
        }
    }
</script>