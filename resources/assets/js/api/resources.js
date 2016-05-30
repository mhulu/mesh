import Vue from 'vue'
import VueResource from 'vue-resource'

const API_ROOT = 'http://homestead.app/api/v1/'

Vue.use(VueResource)

export const MenuResource = Vue.resource(API_ROOT + 'menu')
export const UserInfoResouce = Vue.resource(API_ROOT + 'me')
// export const AuthResource = Vue.resource(API_ROOT + 'auth{/id}')
// export const ArticleResource = Vue.resource(API_ROOT + 'article{/id}{/controller}')
// export const TagResource = Vue.resource(API_ROOT + 'tags{/id}')
// export const CommentResource = Vue.resource(API_ROOT + 'comment{/id}{/controller}')
// export const MobileResource = Vue.resource(API_ROOT + 'mobile{/id}')