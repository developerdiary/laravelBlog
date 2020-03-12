require('./bootstrap');

window.Vue = require('vue');

// Quill Editor
import VueQuillEditor from 'vue-quill-editor'
// require styles
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'

import Quill from 'quill'
import htmlEditButton from 'quill-html-edit-button/src/quill.htmlEditButton.js'
Quill.register('modules/htmlEditButton', htmlEditButton)


Vue.use(VueQuillEditor, /* { default global options } */)

// import the styles TreeViewSelect
import '@riophae/vue-treeselect/dist/vue-treeselect.css'


import iosAlertView from 'vue-ios-alertview';
Vue.use(iosAlertView);

Vue.component('admin-users-component', () => import('./components/admin/UsersComponent'));
Vue.component('admin-profile-component', () => import('./components/admin/ProfileComponent'));
Vue.component('admin-adduser-component', () => import('./components/admin/AdduserComponent'));

Vue.component('admin-post-component', () => import('./components/admin/post/PostComponent'));
Vue.component('admin-addpost-component', () => import('./components/admin/post/AddPostComponent'));
Vue.component('admin-editpost-component', () => import('./components/admin/post/EditPostComponent'));

Vue.component('admin-category-component', () => import('./components/admin/category/CategoryComponent'));
Vue.component('admin-addcategory-component', () => import('./components/admin/category/AddCategoryComponent'));
Vue.component('admin-editcategory-component', () => import('./components/admin/category/EditCategoryComponent'));

Vue.component('admin-tag-component', () => import('./components/admin/tag/TagComponent'));
Vue.component('admin-addtag-component', () => import('./components/admin/tag/AddTagComponent'));
Vue.component('admin-edittag-component', () => import('./components/admin/tag/EditTagComponent'));


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