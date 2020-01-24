require('./bootstrap');

window.Vue = require('vue');


// import the styles TreeViewSelect
import '@riophae/vue-treeselect/dist/vue-treeselect.css'

import iosAlertView from 'vue-ios-alertview';
Vue.use(iosAlertView);

import PostComponent from './components/PostComponent';
import UsersComponent from './components/UsersComponent';
import ProfileComponent from './components/ProfileComponent';
import AdduserComponent from './components/AdduserComponent';
import CategoryComponent from './components/category/CategoryComponent';
import AddcategoryComponent from './components/category/AddcategoryComponent';
import EditcategoryComponent from './components/category/EditcategoryComponent';

Vue.component('post-component', PostComponent);
Vue.component('users-component', UsersComponent);
Vue.component('profile-component', ProfileComponent);
Vue.component('adduser-component', AdduserComponent);
Vue.component('category-component', CategoryComponent);
Vue.component('addcategory-component', AddcategoryComponent);
Vue.component('editcategory-component', EditcategoryComponent);

const app = new Vue({
    el: '#app',
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
