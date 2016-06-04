import Vue from 'vue';
import Register from './components/Register.vue'
import Findpass from './components/Findpass.vue'
import Mplist from './components/Mplist.vue'
import VueResource from 'vue-resource'
Vue.use(VueResource)
// Vue.http.options.root = 'http://wemesh.cn'
// Vue.http.options.root = 'http://homestead.app'
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');
new Vue({
    el:  'body',
    components: {Register, Findpass, Mplist}
})