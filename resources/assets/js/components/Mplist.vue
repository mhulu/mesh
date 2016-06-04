<template>
        <div class="container">
    <div class="row">
      <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6 col-md-offset-3 col-lg-offset-3 col-sm-offset-3 header padding-top-20 center  login">
        <img src="http://static.stario.net/images/wemesh_logo.png">
        <h5>微脉事 WeMesh&trade;</h5>
        <!-- 绑定公众号 -->
         <div v-show="!isBind" transition="fade" class="col-md-12  margin-bottom-40">
          <div class="panel">
          <div class="panel-heading">
            <h3><img src="http://static.stario.net/images/icon32_appwx_logo.png" alt="wechat_logo"> 绑定您的公众号</h3>
          </div>
            <div class="panel-body" style="text-align:left">
                  <ul>
                    <li><strong>微脉事WeMesh&trade;</strong>专为微信公众平台而生，功能更加丰富，工作更加高效</li>
                    <li>授权登录<strong>不会对您的公众号造成任何影响</strong></li>
                    <li>您需要作为公众号的管理员完成下面的操作，请<strong>点击下面的绿色按钮</strong></li>
                  </ul>
            </div>
          </div>
          <a v-bind:href="data.url"> <img src="http://static.stario.net/images/icon_button3_1.png"></a>
        </div>
                <!-- 已绑定公众号列表 -->
         <div v-show="isBind" transition="fade" class="col-md-12  margin-bottom-40">
          <div class="panel">
          <div class="panel-heading">
            <h3><img width="32" src="http://static.stario.net/images/icon64_wx_logo.png" alt=""> 您已绑定的公众号</h3>
          </div>
            <div class="panel-body" style="text-align:left">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                                <th></th>
                                <th>公众号名称</th>
                                <th>授权状态</th>
                                <th>管理操作</th>
                    </tr>
                </thead>
                <tbody>
                  <tr v-for="mp in data.mplist">
                    <td><img src="http://dn-weixinhost-admin-data.qbox.me/fb160fcb930825fb.jpg" width="32px"></td>
                    <td>{{mp.nickname}}</td>
                    <td v-if="1">已授权</td>
                    <td v-else>授权已取消</td>
                    <td><a href="" @click.stop.prevent="goHome(mp.id)" class="btn btn-azure btn-xs">进入后台</a></td>
                  </tr>
                </tbody>  
              </table>
            </div>
          </div>
          <a v-bind:href="data.url" class="btn btn-success btn-lg"><i class="fa fa-wechat"></i> 绑定新的公众号</a>
        </div>
    </div>
  </div>
</div>
</template>

<script>
import store from '../vuex/store'
import {API_ROOT} from '../config'
var  alert = require('vue-strap/dist/vue-strap.min').alert
import { getWxmpList, getUserInfo} from '../vuex/actions'
var swal = require('sweetalert/lib/sweetalert')
export default {
  components: {
    alert, swal
  },
  store: store,
  vuex: {
    actions: {
      getWxmpList, getUserInfo
    }
  },
    created() {
        this.getWxmpList()
    },
  computed: {
    data () {
      return store.state.wxmpList.items
    },
    isBind () {
      return this.data.mplist.length > 0
    }
  },
  methods: {
    goHome (id) {
      this.getUserInfo(id, true) //加true表示要在actions.js中执行更新
    }
  }
}
</script>
<style>
  tbody td {
    line-height: 32px !important;
  }
  [v-cloak] { display: none }
</style>
