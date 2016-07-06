<template>
  <!-- start: SIDEBAR MENU -->
  <ul class="main-navigation-menu ">
    <li v-for="item in menuList" v-bind:class="{'open active': item.url==currentRoute}">
      <a href="{{item.url}}" @click="showElement($event)">
       <div class="item-content">
        <div class="item-media"><i class="fa fa-{{item.icon}}"></i></div>
        <div class="item-inner">
          <span class="title">{{item.name}}</span><i v-if="item.submenu" class="fa fa-angle-down icon-arrow"></i>
        </div>
      </div>
    </a>
    <ul v-if="item.submenu" class="sub-menu fadeInRight">
      <li v-for="sub in item.submenu"><a href="{{sub.url}}"><span class="title">{{sub.name}}</span></a></li>
    </ul>
  </li>  
</ul>
<!-- end: SIDEBAR MENU -->
</template>

<script>
  import * as utils from '../utils'
  import store from '../vuex/store'
  export default {
    computed:{
      currentRoute() {
        var current = window.location.href
        return current.replace(/^\/|\/$/g, '');
      },
      menuList() {
        return store.state.userInfo.items.menu
      }
    },
    methods: {
      /**
       * 二级子菜单点击后出现
       * @判断是否有二级菜单是依据约定
       * nextSibling是否为ul
       */
      showElement: function (event) {
        var el = event.currentTarget.nextSibling.nextSibling
        if (el.tagName == 'UL') {
          event.preventDefault()
          utils.toggleClass('.sub-menu', el, 'show')
        }
      }
    }
  }
</script>