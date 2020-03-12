<template>
<div class="row">
    <div class="col-12">
        <div class="alert alert-primary" v-if="message">
            {{ message }}
        </div>
        <div class="card">
            <div class="card-header">
                <h4>Update Category</h4>                
            </div>
            <div class="card-body">
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Category</label>
                    <div class="col-sm-12 col-md-7">
                        <input v-bind:class="{'is-invalid': errors.name}" type="text" v-model="name" class="form-control" placeholder="Category name">
                        <div class="invalid-feedback" v-if="errors.name">
                            <p>{{ errors.name[0] }}</p>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Parent Category</label>
                    <div class="col-sm-12 col-md-7">

                        <treeselect v-model="value" :multiple="false"  :show-count="true" placeholder="Select Category" :options="categories" v-bind:class="{'is-invalid': errors.value}"/>
                        
                        <div class="invalid-feedback" v-if="errors.value">
                            <p>{{ errors.value[0] }}</p>
                        </div>                       
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Description</label>
                    <div class="col-sm-12 col-md-7">
                        <textarea class="form-control" placeholder="Description" v-model="description" v-bind:class="{'is-invalid': errors.description}"></textarea>
                        <div class="invalid-feedback" v-if="errors.description">
                            <p>{{ errors.description[0] }}</p>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                    <div class="col-sm-12 col-md-7">
                        <button v-bind:disabled="loading" @click="updateCategory" class="btn btn-primary"><span v-if="loading">Adding</span><span v-else>Update</span></button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</template>

<script>

// import the component
import Treeselect from '@riophae/vue-treeselect'


export default {
    components: { 
        Treeselect: () => import('@riophae/vue-treeselect')
    },
    props: {
        category: {
            type: String
        }
    },
    data() {
        return {            
            name: this.getCategorydata('name'),
            description: this.getCategorydata('description'),
            value: this.getCategorydata('parent_id'),
            categories: [],
            errors: [],        
            message: '',
            loading: false,
            categoryId: this.getCategorydata('id'),      
        }
    },
    mounted() {
        this.getCategories();
    },
    methods: {   
        getCategorydata(key) {
            return JSON.parse(this.category)[key];            
        },     
        getCategories() {  
            let _this = this;            
            axios.get(this.$parent.MakeUrl('admin/category')).then((res) => {                    
                    res.data.push({id: 0, label: "Select Category"});                                       
                    res.data.forEach(function (element, i) {                        
                        _this.disableNodeById(element, _this.categoryId);                        
                    });
                    _this.categories = res.data.reverse();
                }).catch((err) => {
            });
        },
        disableNodeById(currentNode, id) {   
            let _this = this;                           
            if (currentNode.id === id) {                   
                currentNode['isDisabled'] = true;             
            }
            if(currentNode.children && currentNode.children.length > 0){                    
                for(let node = 0; node < currentNode.children.length; node ++) {                                                 
                    _this.disableNodeById(currentNode.children[node], id);
                }
            }                                 
        },
        updateCategory() {
            let _this = this;
            _this.errors = [];
            _this.message = '';
            _this.loading = true;
            axios.put(this.$parent.MakeUrl('admin/category/'+this.getCategorydata('id')), {'name': this.name, 'description': this.description, 'parent_id': this.value}).then((res) => {
                _this.loading = false;
                // _this.resetForm();
                _this.message = 'Category has been successfully created!';
            }).catch((err) => {
                _this.errors = err.response.data.errors;
                _this.loading = false;
            });
        },
        resetForm() {
            this.name = '';
            this.description = '';
            this.parent = '';
        }
    }
}
</script>
