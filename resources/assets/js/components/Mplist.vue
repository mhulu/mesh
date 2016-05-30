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
          <a v-bind:href="info.url"> <img src="http://static.stario.net/images/icon_button3_1.png"></a>
        </div>
                <!-- 已绑定公众号列表 -->
         <div v-show="isBind" transition="fade" class="col-md-12  margin-bottom-40">
          <div class="panel">
          <div class="panel-heading">
            <h3><img width="32" src="http://static.stario.net/images/icon64_wx_logo.png" alt=""> 您已绑定的公众号</h3>
          </div>
            <div class="panel-body" style="text-align:left">
                  <ul>
                    <li v-for="mp in info.mplist"> {{mp}}</li>
                  </ul>
            </div>
          </div>
          <a v-bind:href="info.url" class="btn btn-success btn-lg"><i class="fa fa-wechat"></i> 绑定新的公众号</a>
        </div>
    </div>
  </div>
</div>
</template>

<script>
var  alert = require('vue-strap/dist/vue-strap.min').alert
import * as utils from '../utils'
var swal = require('sweetalert/lib/sweetalert')
export default {
  data () {
    return {
      info: []
    }
  },
  ready () {
    this.getInfo()
  },
  components: {
    alert, swal
  },
  methods: {
    getInfo: function () {
        this.$http.get('api/v1/mplist').then(function (response) {
          this.info = response.data
        })
      }
  },
  computed: {
    isBind() {
      if (this.info.mplist !== 'undefined') {
        return this.info.mplist.length > 0
      }
    }
  }
}
</script>

