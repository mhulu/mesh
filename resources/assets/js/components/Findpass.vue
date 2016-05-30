<template>
        <!-- FORM START -->
        <form class="form-horizontal">
         <div class="form-group">
          <label class="col-sm-3 control-label">
          手机号码
          </label>
          <div class="col-sm-9">
            <input type="text"  placeholder=" 输入手机号" name="newMobile" v-model="credentials.mobile" required class="form-control">
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-3 control-label">
          短信验证
          </label>
          <div class="col-sm-4">
            <input type="text"  placeholder=" 输入验证码" name="authCode" v-model="credentials.authCode" required class="form-control">
          </div>
          <div class="col-sm-5">
            <count-down @click.prevent="validateMobile" :disabled="notMobile"></count-down>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-3 control-label">
          输入密码
          </label>
          <div class="col-sm-9">
             <input type="text"  class="form-control" placeholder=" 输入您的密码" name="password" v-model="credentials.password" required>
          </div>
        </div>

                <div class="form-group">
          <label class="col-sm-3 control-label">
          密码确认
          </label>
          <div class="col-sm-9">
             <input type="text"  class="form-control" name="password_confirmation" placeholder=" 再次输入您的密码" v-model="credentials.rePassword"  required>
          </div>
        </div>
        <button type="submit" class="btn btn-light-blue btn-lg btn-block margin-bottom-10" @click.stop.prevent="signIn"><i class="fa fa-sign-in"></i> 确定</button>
         </form>
          <alert
          :show.sync="showInfo"
          :duration="3000"
          type="info"
          dismissable>
          <p><i class="fa fa-warning"></i> {{info}}</p>
        </alert>

</template>

<script>
var  alert = require('vue-strap/dist/vue-strap.min').alert
import * as utils from '../utils'
import * as validate from '../validator'
import countDown from './CountDownBtn.vue'
var swal = require('sweetalert/lib/sweetalert')
export default {
  replace: true,
  data () {
    return {
      credentials: {
        mobile: '',
        password: '',
        rePassword: '',
        authCode: ''
      },
      showInfo: false,
      error: '',
      info: ''
    }
  },
  components: {
    alert,
    countDown,
    swal
  },
  methods: {
    signIn () {
      var data = {
        mobile: this.credentials.mobile,
        password: this.credentials.password,
        password_confirmation: this.credentials.rePassword,
        authCode: this.credentials.authCode
      }
/**
 * 发送数据，以findpass作为参数
 */
      this.$http.post('auth/findpass', data).then(function (response) {
            swal({
              title: '操作成功!',
              text: '您已经成功重置了您的密码',
              type: 'success',
              closeOnConfirm: false,
              confirmButtonText: "重新登陆",
              confirmLoadingButtonColor: '#DD6B55'
            }, function(){
              window.location.href='/login'
            });
      }, function (response) {
        this.$set('error', utils.findFirst(response.data))
       swal('出错啦!',this.error, 'error')
      })
    },
    validateMobile () {
      var data = {
        mobile: this.credentials.mobile
      }
      this.$http.post('service/sendSms', data).then(function (response) {
        this.showInfo = true
        this.info = '验证码已经发送,请注意查收'
      }, function (response) {
        this.$set('error', utils.findFirst(response.data))
        swal('出错啦!',this.error, 'error')
      })
    }
  },
  computed: {
    notMobile: function () {
      return !validate.isMobile(this.credentials.mobile)
    }
  }
}
</script>

