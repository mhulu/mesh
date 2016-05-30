<template>
  <button class="btn {{class}}" id="getAuthcode" @click.stop.prevent="getAuthcode($event)"><slot>获取短信验证码</slot></button>
</template>
<script>
  import * as utils from '../utils'
  export default {
    props: {
      duration: {},
      class: {}
    },
    data: function () {
      return {
        class: 'btn-azure',
        duration: 60
      }
    },
    methods: {
      getAuthcode (e) {
        utils.countdown(e.target, this.duration)
      }
    }
  }
</script>