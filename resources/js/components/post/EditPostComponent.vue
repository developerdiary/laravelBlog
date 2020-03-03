<template>
   <div class="row">
       <div class="col-12">
            <div class="alert alert-primary" v-if="message">
                {{ message }}            
            </div>
        </div>
        <div class="col-9">            
            <div class="card">
                <div class="card-header">
                    <h4>General</h4>
                    <div class="card-header-action">
                      <a data-collapse="#genralcollapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div> 
                <div class="collapse show" id="genralcollapse">
                    <div class="card-body">
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" v-bind:class="{'is-invalid': errors.title}" v-model="input.title" class="form-control" placeholder="Title">
                                <div class="invalid-feedback" v-if="errors.title">
                                    <p>{{ errors.title[0] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Sub Title</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" v-bind:class="{'is-invalid': errors.subtitle}" v-model="input.subtitle" class="form-control" placeholder="Sub Title">
                                <div class="invalid-feedback" v-if="errors.subtitle">
                                    <p>{{ errors.subtitle[0] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Featured Image</label>
                        
                            <div  class="col-sm-12 col-md-7" v-if="!input.featured_image">                    
                                <input type="file" @change="onFileChange" name="featured_image" class="form-control">
                            </div>
                            <div  class="col-sm-12 col-md-7" v-else>
                                <img :src="input.featured_image" />
                                <button class="btn btn-danger"  @click="removeImage">Remove image</button>
                            </div>                            
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Select Categories</label>
                            <div class="col-sm-12 col-md-7">                                                        
                                <treeselect v-model="input.category_value" :multiple="true" :options="input.categories" placeholder="Select Categories" />
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Select Tags</label>
                            <div class="col-sm-12 col-md-7">                                                        
                                <treeselect v-model="input.tag_value" :multiple="true" :options="input.tags" placeholder="Select Tags" />
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            <div class="card">                
                <div class="card-body">                    
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Description</label>
                        <div class="col-sm-12 col-md-7">     
                            <quill-editor ref="myTextEditor" v-model="input.description" :options="editorOption"></quill-editor>
                        </div>
                    </div> 
                </div>
            </div>

            <div class="card"> 
                <div class="card-header">
                    <h4>More Fields</h4>
                    <div class="card-header-action">
                      <a data-collapse="#morecollapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>               
                <div class="collapse show" id="morecollapse">
                    <div class="card-body">                               
                        <imagegallery :gallery="input.gallery"></imagegallery>
                    </div>
                </div>
            </div>

        </div>

        <!--Start Sidebar -->
        <div class="col-3">
            
            <div class="card">
                <div class="card-header">  
                    <h4>Publish </h4>
                    <div class="card-header-action">
                      <label class="col-form-label"><strong>{{ updated_at }}</strong></label>
                    </div>
                </div>

                <div class="card-body">
                    <div class="form-group row mb-4">                        
                        <label class="col-form-label text-md-left col-lg-6">Status : <strong>{{ is_published }}</strong></label>
                        <div class="col-lg-3 text-md-right">
                            <button class="btn btn-primary" @click="updatePost('draft')"><span>Draft</span></button>
                        </div>
                        <div class="col-lg-3 text-md-right">                            
                            <button class="btn btn-primary" @click="updatePost('publish')"><span>Update</span></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">                
                    <h4>Revision</h4>
                    <div class="card-header-action">
                      <a data-collapse="#revisioncollapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>  
                <div class="collapse show" id="revisioncollapse">           
                    <div class="card-body">
                        <div class="form-group">                      
                            <div class="form-check">   
                                <i class="form-check-input fas fa-history"></i>                         
                                <label class="form-check-label"><a href="#" for="standardRadio">Revision 1</a></label>
                            </div>
                            <div class="form-check">                            
                                <i class="form-check-input fas fa-history"></i>                         
                                <label class="form-check-label"><a href="#" for="standardRadio">Revision 2</a></label>
                            </div>
                            <div class="form-check">                            
                                <i class="form-check-input fas fa-history"></i>                         
                                <label class="form-check-label"><a href="#" for="standardRadio">Revision 3</a></label>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">                
                    <h4>Post Features</h4>
                    <div class="card-header-action">
                      <a data-collapse="#featurescollapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>  
                <div class="collapse show" id="featurescollapse">           
                    <div class="card-body">
                        <div class="form-group">                      
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" v-model="input.features" value="trending" id="trendingRadio">
                                <label class="form-check-label" for="trendingRadio">Trending Most View</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" v-model="input.features" value="youmaylike" id="youmaylikeRadio">
                                <label class="form-check-label" for="youmaylikeRadio">You May Like</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <!--End Sidebar -->
    </div> 
</template>

<script>

import Treeselect from '@riophae/vue-treeselect'
import Imagegallery from '../ImageGalleryComponent';

export default {    
    components: { 
        Treeselect,
        Imagegallery
    },
    props: {
        post: {
            type: String
        }
    },
    data(){
        return {
            loading: false,
            input: {
                title: this.getPostData('title'),
                subtitle: this.getPostData('subtitle'),
                featured_image: this.getPostData('image'),
                change_image: this.getPostData('ogimage'),
                gallery: this.getPostData('gallery'),
                features: this.getPostData('features'),
                categories: [],
                tags: [],            
                category_value: this.getPostData('category'),
                tag_value: this.getPostData('tag'),
                description: this.getPostData('body'),                
            },             
            updated_at: this.getPostData('updated_at'),
            is_published: this.getPostData('is_published'), 
            message : '',
            errors:[],
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
                    _this.input.categories = res.data;
                }).catch((err) => {
            });
        },
        getTags(){  
            let _this = this;            
            axios.get(this.$parent.MakeUrl('admin/tag/all')).then((res) => {                    
                    _this.input.tags = res.data;
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
            }else if(key == 'features'){
                var amarray = [];
                var postData = JSON.parse(this.post)[key];               
                // console.log(postData);
                postData.forEach(function (features, index) {                    
                    amarray.push(features);                                        
                });
                return amarray;
            }else{
                return JSON.parse(this.post)[key];
            }            
        },
        updatePost(status){
            let _this = this;
            _this.errors = [];
            _this.message = '';
            _this.loading = true;
            axios.put(this.$parent.MakeUrl('admin/post/'+this.getPostData('id')), {input: this.input, status: status}).then((res) => {
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
                _this.input.featured_image = e.target.result;
                _this.input.change_image = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        removeImage: function (e) {
            this.input.featured_image = '';
            this.input.change_image = '';
        },
        updateGallery: function(image){ // Child to parent component value pass
            this.input.gallery = image;
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