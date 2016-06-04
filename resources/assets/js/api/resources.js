import Vue from 'vue'
import VueResource from 'vue-resource'
import {API_ROOT} from '../config'
// const API_ROOT = 'http://homestead.app/api/v1/'
// const API_ROOT = 'http://wemesh.cn'
// Vue.http.options.root = 'http://homestead.app'
Vue.use(VueResource)

export const WxmpResource = Vue.resource(API_ROOT + 'mplist')
export const UserInfoResouce = Vue.resource(API_ROOT + 'wxmp{/id}')
// export const AuthResource = Vue.resource(API_ROOT + 'auth{/id}')
// export const ArticleResource = Vue.resource(API_ROOT + 'article{/id}{/controller}')
// export const TagResource = Vue.resource(API_ROOT + 'tags{/id}')
// export const CommentResource = Vue.resource(API_ROOT + 'comment{/id}{/controller}')
// export const MobileResource = Vue.resource(API_ROOT + 'mobile{/id}')