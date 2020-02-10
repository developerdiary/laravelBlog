<template>
   <div class="row">
        <div class="col-12">        
            <div class="alert alert-primary" v-if="message">
                {{ message }}            
            </div>
            <div class="card">
                <div class="card-header">                
                    <h4>Edit Post</h4>
                </div>
                <div class="card-body">
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" v-bind:class="{'is-invalid': errors.title}" v-model="title" class="form-control" placeholder="Title">
                            <div class="invalid-feedback" v-if="errors.title">
                                <p>{{ errors.title[0] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Description</label>
                        <div class="col-sm-12 col-md-7">     
                            <quill-editor ref="myTextEditor" v-model="description" :options="editorOption"></quill-editor>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Featured Image</label>
                    
                        <div  class="col-sm-12 col-md-7" v-if="!featured_image">                    
                            <input type="file" @change="onFileChange" name="featured_image" class="form-control">
                        </div>
                        <div  class="col-sm-12 col-md-7" v-else>
                            <img :src="featured_image" />
                            <button class="btn btn-danger"  @click="removeImage">Remove image</button>
                        </div>
                        
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Select Categories</label>
                        <div class="col-sm-12 col-md-7">                                                        
                            <treeselect v-model="category_value" :multiple="true" :options="categories" placeholder="Select Categories" />
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Select Tags</label>
                        <div class="col-sm-12 col-md-7">                                                        
                            <treeselect v-model="tag_value" :multiple="true" :options="tags" placeholder="Select Tags" />
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button class="btn btn-primary" @click="updatePost"><span>Update</span></button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div> 
</template>

<script>

import Treeselect from '@riophae/vue-treeselect'

export default {    
    components: { 
        Treeselect
    },
    props: {
        post: {
            type: String
        }
    },
    data(){
        return {
            loading: false,
            title: this.getPostData('title'),
            featured_image: '',
            message : '',
            errors:[],
            categories: [],
            tags: [],            
            category_value: this.getPostData('category'),
            tag_value: this.getPostData('tag'),
            description:  this.getPostData('body'),
            editorOption: {
                modules: {
                    htmlEditButton: {}
                }                
            }
        }
    },
    mounted() {
        this.getCategories();
        this.getTags();        
    },
    methods: {
        getCategories() {  
            let _this = this;            
            axios.get(this.$parent.MakeUrl('admin/category')).then((res) => {                    
                    _this.categories = res.data;
                }).catch((err) => {
            });
        },
        getTags(){  
            let _this = this;            
            axios.get(this.$parent.MakeUrl('admin/tag/all')).then((res) => {                    
                    _this.tags = res.data;
                }).catch((err) => {
            });
        },
        getPostData(key){
            if(key == 'category'){
                var amarray = [];
                var postData = JSON.parse(this.post)[key];               
                postData.forEach(function (category, index) {                    
                    amarray.push(category.id);                                        
                });
                return amarray;
            }else if(key == 'tag'){
                var amarray = [];
                var postData = JSON.parse(this.post)[key];               
                postData.forEach(function (tag, index) {                    
                    amarray.push(tag.id);                                        
                });
                return amarray;
            }else{
                return JSON.parse(this.post)[key];
            }            
        },
        updatePost(){
            let _this = this;
            _this.errors = [];
            _this.message = '';
            _this.loading = true;
            axios.put(this.$parent.MakeUrl('admin/post/'+this.getPostData('id')), {'title': this.title, 'description': this.description, 'category_value': this.category_value, 'tag_value': this.tag_value}).then((res) => {
                _this.loading = false;
                // _this.resetForm();
                _this.message = 'Post has been successfully updated!';
            }).catch((err) => {
                _this.errors = err.response.data.errors;
                _this.loading = false;
            });

        },
        onFileChange(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.createImage(files[0]);
        },
        createImage(file) {
            var image = new Image();
            var reader = new FileReader();
            let _this = this;

            reader.onload = (e) => {
                _this.featured_image = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        removeImage: function (e) {
            this.featured_image = '';
        }
    },
}
</script>


<style>

.modal-backdrop, .modal-backdrop.in{
  display: none;
}
img {
  width: 50%;  
  display: block;
  margin-bottom: 10px;
}
</style>