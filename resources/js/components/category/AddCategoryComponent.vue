<template>
<div class="row">
    <div class="col-12">
        <div class="alert alert-primary" v-if="message">
            {{ message }}
        </div>        
        <div class="card">
            <div class="card-header">                
                <h4>Add a New Category</h4>
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

                        <treeselect v-model="value" :multiple="false"  :show-count="true" placeholder="Select Category" :options="categories" v-bind:class="{'is-invalid': errors.parent_id}"/>

                        
                        <div class="invalid-feedback" v-if="errors.parent_id">
                            <p>{{ errors.parent_id[0] }}</p>
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
                        <button v-bind:disabled="loading" @click="addCategory" class="btn btn-primary"><span v-if="loading">Adding</span><span v-else>Add</span></button>
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
    components: { Treeselect },
    data() {
        return {            
            name: '',
            description: '',
            value: null,
            categories: [],
            errors: [],        
            message: '',
            loading: false           
        }
    },
    mounted() {
        this.getCategories();
    },
    methods: {
        getCategories() {            
            axios.get(this.$parent.MakeUrl('admin/category')).then((res) => {
                this.categories = res.data;
            }).catch((err) => {
            });
        },
        addCategory() {
            let _this = this;
            _this.errors = [];
            _this.message = '';
            _this.loading = true;
            axios.post(this.$parent.MakeUrl('admin/category'), {'name': this.name, 'description': this.description, 'parent_id': this.value}).then((res) => {
                _this.loading = false;
                _this.resetForm();
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
