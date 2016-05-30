<template>
    <a  title="全屏开关" v-on:click.prevent="fullscreen"> <i class="fa fa-expand" v-if="!isfullscreen"></i>  <i class="fa fa-compress" v-if="isfullscreen"></i></a>
</template>

<script>
    import { fullscreen } from '../vuex/actions'
    export default {
      vuex: {
        getters: {
          isfullscreen: state => state.fullscreen.isfullscreen
        },
        actions: {
          fullscreen
        }
      }
    }
</script>