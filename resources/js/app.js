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

import UsersComponent from './components/UsersComponent';
import ProfileComponent from './components/ProfileComponent';
import AdduserComponent from './components/AdduserComponent';


import PostComponent from './components/post/PostComponent';
import AddPostComponent from './components/post/AddPostComponent';
import EditPostComponent from './components/post/EditPostComponent';


import CategoryComponent from './components/category/CategoryComponent';
import AddCategoryComponent from './components/category/AddCategoryComponent';
import EditCategoryComponent from './components/category/EditCategoryComponent';

import TagComponent from './components/tag/TagComponent';
import AddTagComponent from './components/tag/AddTagComponent';
import EditTagComponent from './components/tag/EditTagComponent';

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