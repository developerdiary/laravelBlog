require('./bootstrap');

window.Vue = require('vue');

Vue.use(require('vue-moment'));

import BlogIndexComponent from './components/frontend/blog/IndexComponent';
Vue.component('blog-index-component', BlogIndexComponent);

import BlogSingleComponent from './components/frontend/blog/SingleComponent';
Vue.component('blog-single-component', BlogSingleComponent);


const web = new Vue({
    el: '#web',
    data() {
        return {
            user: AuthUser
        }
    },
    methods: {
        userCan(permission) {
            if(this.user && this.user.allPermissions.includes(permission)) {
                return true;
            }
            return false;
        },
        MakeUrl(path) {
            return BaseUrl(path);
        }
    }
});