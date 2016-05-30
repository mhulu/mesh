<template>
    <div id="off-sidebar"  class="sidebar hidden-print">
      <div class="sidebar-wrapper">
        <tabs class="nav nav-tabs nav-justified">
            <tab header="联系人">
            <div role="tabpanel" class="tab-pane active" id="messages">
            <div class="users">
            <div class="users-list">
              <div class="sidebar-content" id="chatbox">
                <h5 class="sidebar-title">微信留言</h5>
                <ul class="media-list" id="users">
                  <li v-for="item in items" class="media">
                    <a v-on:click="checkChat">
                      <i class="status-online">3天前</i>
                      <img :src="item.avatar" class="media-object" alt="">
                      <div class="media-body">
                        <h4 class="media-heading">{{item.from}}</h4>
                        <span>普通用户</span>
                      </div>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="user-chat">
              <!-- <chat-clip></chat-clip> -->
            </div>
            </div>
          </div>
            </tab>
            <tab header="分组设置">
                          <div role="tabpanel" class="tab-pane active" id="messages">
            <div class="users-list">
              <div class="sidebar-content" id="chatbox">
                <ul class="media-list">
                  <li v-for="item in groups" class="media">
                    <a v-on:click="checkChat">
                      <i class="status-online">3天前</i>
                      <img :src="item.avatar" class="media-object" alt="">
                      <div class="media-body">
                        <h4 class="media-heading">{{item.from}}</h4>
                        <span>普通用户</span>
                      </div>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="user-chat">
              <chat-clip></chat-clip>
            </div>
          </div>
            </tab>
        </tabs>
      </div>
    </div>

</template>

<script>
  var Ps = require('perfect-scrollbar')
  import chatClip from '../components/ChatClip.vue'
  import Tab from '../components/Tab.vue'
  import Tabs from '../components/Tabset.vue'
  import * as utils from '../utils'
  export default{
    props: ['api'],
    data: function () {
      return {
        items: {},
        groups: [
            '管理', '常用'
        ]
      }
    },
    ready: function () {
      this.$http.get(this.api).then(function (response) {
        this.items = response.data
      })
      var container = document.getElementById('users')
      Ps.initialize(container)
    },
    methods: {
      checkChat: function () {
        var el = document.getElementById('users')
        utils.addClass(el, 'chat-open')
      }
    },
    components: {
      chatClip, Tab, Tabs
    }
  }
</script>