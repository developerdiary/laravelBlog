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

import UsersComponent from './components/admin/UsersComponent';
import ProfileComponent from './components/admin/ProfileComponent';
import AdduserComponent from './components/admin/AdduserComponent';


import PostComponent from './components/admin/post/PostComponent';
import AddPostComponent from './components/admin/post/AddPostComponent';
import EditPostComponent from './components/admin/post/EditPostComponent';


import CategoryComponent from './components/admin/category/CategoryComponent';
import AddCategoryComponent from './components/admin/category/AddCategoryComponent';
import EditCategoryComponent from './components/admin/category/EditCategoryComponent';

import TagComponent from './components/admin/tag/TagComponent';
import AddTagComponent from './components/admin/tag/AddTagComponent';
import EditTagComponent from './components/admin/tag/EditTagComponent';

Vue.component('post-component', PostComponent);
Vue.component('addpost-component', AddPostComponent);
Vue.component('editpost-component', EditPostComponent);


Vue.component('users-component', UsersComponent);
Vue.component('profile-component', ProfileComponent);
Vue.component('adduser-component', AdduserComponent);

Vue.component('category-component', CategoryComponent);
Vue.component('addcategory-component', AddCategoryComponent);
Vue.component('editcategory-component', EditCategoryComponent);


Vue.component('tag-component', TagComponent);
Vue.component('addtag-component', AddTagComponent);
Vue.component('edittag-component', EditTagComponent);


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