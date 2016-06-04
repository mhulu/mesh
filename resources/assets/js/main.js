import Vue from 'vue'
// import VueRouter from 'vue-router'
// import registerRouters from './routers'
import VueResource from 'vue-resource'
import store from './vuex/store'
// import { sync } from 'vuex-router-sync'
// Comment these three for local build.
// Vue.config.devtools = false
// Vue.config.debug = false
// Vue.config.silent = true

import Register from './components/Register.vue'
import Fullscreen from './components/Fullscreen.vue'
import msgBox from './components/MsgBox.vue'
import Dropdown from './components/Dropdown.vue'
import Breadcrumb from './components/Breadcrumb.vue'
import Sidemenu from './components/Sidemenu.vue'
import Chatbox from './components/Chatbox.vue'
import UserInfo from './components/UserInfo.vue'
import * as utils from './utils'
import { getUserInfo } from './vuex/actions'
// import * as api from './vuex/modules/api'

var Ps = require('perfect-scrollbar')

Vue.use(VueResource)
// Vue.use(VueRouter)
// Vue.http.options.root = 'http://wemesh.cn/api'
// Vue.http.options.root = 'http://homestead.app/api'
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');

// const router = new VueRouter({
//   hashbang: false
// })
// sync(store, router)

// registerRouters(router)

// router.start(App, '#app')

new Vue({
    el: 'body',
    data: function () {
      return {
        sidebarOn: false,
        isNavbarCollapsed: false,
        isChatBoxOn: false,
        menus: {}
      }
    },
    ready: function () {
        if (utils.hasId('sidebox')) {
          var container = document.getElementById('sidebox')
          Ps.initialize(container)
        }
    },
   methods: {
          navbarCollapsed: function () {
            var el = document.getElementById('navbar-collapse')
            if (!utils.hasClass(el, 'in')) {
              utils.addClass(el, 'in')
            } else {
              utils.removeClass(el, 'in')
            }
          },
          toggleMsg: function () {
            var el = document.getElementById('box')
            if (utils.hasClass(el, 'app-offsidebar-open')) {
              utils.removeClass(el, 'app-offsidebar-open')
              this.isChatBoxOn = !this.isChatBoxOn
            }
          },
          toggleChatBox: function () {
            var el = document.getElementById('box')
            this.isChatBoxOn = !this.isChatBoxOn
            if (this.isChatBoxOn) {
              utils.addClass(el, 'app-offsidebar-open')
            } else {
              utils.removeClass(el, 'app-offsidebar-open')
            }
          },
          toggleSidebar: function () {
            var el = document.getElementById('box')
            this.sidebarOn = !this.sidebarOn
            if (this.sidebarOn) {
              utils.addClass(el, 'app-slide-off')
            } else {
              utils.removeClass(el, 'app-slide-off')
            }
          }
        },
    store: store,
      vuex: {
          getters: {
              userInfo: ({userInfo}) => userInfo.items
          },
          actions: {
              getUserInfo
          }
      },
    created() {
        this.getUserInfo()
    },
    components: {
         Sidemenu, Chatbox, Dropdown, Fullscreen, msgBox, Breadcrumb, UserInfo
        }
    })