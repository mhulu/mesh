<template>
    <div id="box" class="app-sidebar-fixed app-navbar-fixed ">
    <div class="sidebar app-aside hidden-print " id="sidebar" >
    <div class="sidebar-container" id="sideMenu">
      <!-- start: SEARCH FORM -->
      <div class="search-form hidden-md hidden-lg">
        <form class="navbar-form" role="search">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="搜索关键字...">
            <button class="btn search-button" type="submit">
              <i class="fa fa-search"></i>
            </button>
          </div>
        </form>
      </div>
      <!-- end: SEARCH FORM -->
      <!-- start: USER OPTIONS -->
      <user-info></user-info>
      <!-- end: USER OPTIONS -->
      <!-- start: SIDEBAR -->
      <nav>
        <component is = "sidemenu"></component>
      </nav>
      <!-- end: SIDEBAR -->
    </div>
  </div>
    <div class="app-content">
        <!-- top navbar -->
         <header class="navbar navbar-default navbar-static-top hidden-print">
    <!-- start: NAVBAR HEADER -->
    <div class="navbar-header">
        <button  class="menu-mobile-toggler btn pull-left hidden-md hidden-lg" id="horizontal-menu-toggler" >
            <i class="fa fa-bars"></i>
        </button>
        <button   class="sidebar-mobile-toggler btn pull-left hidden-md hidden-lg" v-on:click="toggleSidebar">
            <i class="fa fa-bars"></i>
        </button>
        <a class="navbar-brand"> <img src="http://7lrzqf.com1.z0.glb.clouddn.com/images/westar.png" alt="WeStar" /> </a>
        <a class="navbar-brand navbar-brand-collapsed" href="#"> <img src="http://7lrzqf.com1.z0.glb.clouddn.com/images/westar.png" alt="WeStar" />  </a>
                <button class="btn pull-right menu-toggler  visible-xs-block" id="menu-toggler" v-on:click="navbarCollapsed" >
            <i v-bind:class="isNavbarCollapsed ? 'fa fa-folder-open' : 'fa fa-folder'"></i> <small><i class="fa fa-caret-down margin-left-5"></i></small>         
        </button>
    </div>
    <!-- end: NAVBAR HEADER -->
    <!-- start: NAVBAR COLLAPSE -->
    <div class="navbar-collapse collapse" id="navbar-collapse">
        <ul class="nav navbar-left hidden-sm hidden-xs">
            <li>
                <fullscreen></fullscreen> 
            </li>
            <li>
                <form role="search" class="navbar-form main-search">
                    <div class="form-group">
                        <input type="text" placeholder="搜索关键字..." class="form-control">
                        <button class="btn search-button" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </li>
        </ul>
        <ul class="nav navbar-right">
            <!-- start: MESSAGES DROPDOWN -->    
            <dropdown class="dropdown">
        <a class=" dropdown-toggle" type="button"  data-toggle="dropdown"  v-on:click="toggleMsg">
            <i class="fa fa-envelope"></i> 
        </a>
           <msg-box  api="http://demo1429768.mockable.io/messages"></msg-box>   
           </dropdown>  
            <!-- end: MESSAGES DROPDOWN -->
        </ul>
        <!-- start: MENU TOGGLER FOR MOBILE DEVICES -->
        <div class="close-handle visible-xs-block menu-toggler" v-on:click="navbarCollapsed">
            <div class="arrow-left"></div>
            <div class="arrow-right"></div>
        </div>
        <!-- end: MENU TOGGLER FOR MOBILE DEVICES -->
    </div>
    <button v-on:click="toggleChatBox" class="sidebar-mobile-toggler dropdown-off-sidebar btn hidden-md hidden-lg">
        <i class="fa" v-bind:class="isChatBoxOn ? 'fa-angle-double-right' : 'fa-angle-double-left'"></i>
    </button>

    <button v-on:click="toggleChatBox" class="dropdown-off-sidebar btn hidden-sm hidden-xs">
        <i class="fa" v-bind:class="isChatBoxOn ? 'fa-angle-double-right' : 'fa-angle-double-left'"></i>
    </button>
    <!-- end: NAVBAR COLLAPSE -->
</header>
<!-- end: TOP NAVBAR -->
        <!-- main content -->
        <div  class="main-content">
          <div class="wrap-content container">
                <breadcrumb></breadcrumb>
               <router-view></router-view>
          </div>
        </div>
        <!-- / main content -->
      </div>
      <!-- footer -->
      <footer data-ng-include=" 'assets/views/partials/footer.html' " class="hidden-print"></footer>
      <!-- / footer -->
       <chatbox api="http://demo1429768.mockable.io/messages"></chatbox>
</div>
</template>

<script>
import store from './vuex/store'
import Sidemenu from './components/Sidemenu.vue'
import Chatbox from './components/Chatbox.vue'
import * as utils from './utils'
import Fullscreen from './components/Fullscreen.vue'
import msgBox from './components/MsgBox.vue'
import Dropdown from './components/Dropdown.vue'
import UserInfo from './components/UserInfo.vue'
import Breadcrumb from './components/Breadcrumb.vue'

var Ps = require('perfect-scrollbar')

export default {
    data: function () {
      return {
        sidebarOn: false,
        isNavbarCollapsed: false,
        isChatBoxOn: false
      }
    },
    ready: function () {
        if (utils.hasId('sideMenu')) {
          var container = document.getElementById('sideMenu')
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
    components: {
         Sidemenu, Chatbox, Dropdown, Fullscreen, msgBox, UserInfo, Breadcrumb
    }
}
</script>