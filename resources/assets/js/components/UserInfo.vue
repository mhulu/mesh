<template>
    <div class="nav-user-wrapper" >
        <div class="media">
          <div class="media-left">
            <a class="profile-card-photo" href=""><img :src="userInfo.avatar"></a>
          </div>
          <div class="media-body">
            <span class="media-heading text-white">{{userInfo.name}}</span>
            <div class="text-small text-white-transparent">
              {{userInfo.role}}
            </div>
          </div>
          <div class="media-right media-middle">
            <dropdown>
              <a href class="dropdown-toggle btn btn-transparent text-white " type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-caret-down"></i> </a>
              <ul class="dropdown-menu pull-right fadeInUp">
                <li>
                  <a href="asdf">个人资料</a>
                </li>
                <li>
                  <a href="/me/messages"> 消息中心 ({{userInfo.messages.length}}) </a>
                </li>
                <li>
                  <a> 锁定屏幕 </a>
                </li>
                <li class="divider"></li>
                <li>
                  <a href="/logout" @click="onLogout"> 退出账号 </a>
                </li>
              </ul>
            </dropdown>
          </div>
        </div>
      </div>
</template>

<script>
  import store from '../vuex/store'
  import Dropdown from './Dropdown.vue'
  export default {
    components: {
        Dropdown
    },
    methods: {
        onLogout: function () {
            window.sessionStorage.clear()
        }
    },
  computed: {
    userInfo: function () {
      return store.state.userInfo.items
    }
  }
  }
</script>