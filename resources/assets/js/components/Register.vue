<template>
<form>
        <div  v-show="!loginTab" class="form-horizontal">
       <div class="form-group">
        <label class="col-sm-3 control-label">
          手机号码
        </label>
        <div class="col-sm-9">
          <input type="text"  placeholder=" 输入手机号"  v-model="credentials.mobile" required class="form-control" />
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-3 control-label">
          短信验证
        </label>
        <div class="col-sm-4">
          <input type="text"  placeholder=" 输入验证码"  v-model="credentials.authCode" required class="form-control" />
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
         <input type="password"  class="form-control" placeholder=" 输入您的密码" v-model="credentials.password" required />
       </div>
      </div>

      <div class="form-group">
        <label class="col-sm-3 control-label">
          密码确认
        </label>
        <div class="col-sm-9">
         <input type="password"  class="form-control" placeholder=" 再次输入您的密码" v-model="credentials.rePassword"  required />
       </div>
      </div>
      <button type="submit" class="btn btn-light-blue btn-lg btn-block margin-bottom-10" @click.stop.prevent="signup"><i class="fa fa-sign-in"></i> 注册</button>
      </div>
      </form>
          <alert
          :show.sync="showInfo"
          :duration="5000"
          type="info"
          dismissable>
          <p><i class="fa fa-warning"></i> {{info}}</p>
        </alert>
</template>

     <script>
     import countDown from './CountDownBtn.vue'
     import * as utils from '../utils'
     var  alert = require('vue-strap/dist/vue-strap.min').alert
     import * as validate from '../validator'
     var swal = require('sweetalert/lib/sweetalert')
     export default {
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
                info: '',
                isMobile: false
            }
          },
     components: {
      countDown, alert, swal
     },
     methods: {
      signup () {
        if (this.credentials.mobile == '' || this.credentials.password == '' ||this.credentials.rePassword == '' || this.credentials.authCode == '') {
          return false
        }
        var data = {
          mobile: this.credentials.mobile,
          password: this.credentials.password,
          password_confirmation: this.credentials.rePassword,
          authCode: this.credentials.authCode
        }
        this.$http.post('register', data).then(function (response) {
            swal({
              title: '操作成功!',
              text: '您已经成功注册',
              type: 'success',
              closeOnConfirm: false,
              confirmButtonText: "进入系统",
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
          this.$http.post('service/sendSms', {'mobile': this.credentials.mobile}).then(function (response) {
             this.showInfo = true
            this.info = response.data.result
          }, function (response) {
            this.$set('error', utils.findFirst(response.data))
            swal({
              title: '出错啦!',
              text: '该手机已经注册',
              type: 'error',
              closeOnConfirm: false,
              showCancelButton: true,
              cancelButtonText: "重新填写",
              confirmButtonText: "返回登陆",
              confirmLoadingButtonColor: '#DD6B55'
            }, function(){
              window.location.href='/login'
            });
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