<template>
<div class="row" v-if="$parent.userCan('manage-users')">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Categories <span v-if="total">({{ total }})</span></h4>
                <div class="card-header-action">
                    <a v-bind:href="$parent.MakeUrl('admin/category/create')" class="btn btn-primary">Add <i class="fas fa-plus"></i></a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive table-invoice" v-if="!loading">
                    <div class="table table-striped" v-if="categories.length">

                        <ul v-for="category in categories" v-bind:key="category.id" class="tree-view-category">                                
                            <category-table-tree :node="category" ></category-table-tree>
                        </ul>
                        <!-- <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Slug</th>
                                <th>Count</th>
                                <th></th>
                            </tr>
                        </thead> -->
                        <!-- <tbody>
                            
                            <template v-for="category in categories">
                                <tr v-bind:key="category.id">
                                    <td>{{ category.name }}</td>
                                    <td>{{ category.description }}</td>
                                    <td>{{ category.slug }}</td>
                                    <td>0</td>
                                    <td class="text-right">
                                        <button  @click="deleteCategory(category.id, index)" class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <a class="btn btn-primary" v-bind:href="category.editlink">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                <template v-if="category.children && category.children.length">
                                    <tr v-for="child in category.children" v-bind:key="child.id">
                                        <td> - {{ child.name }}</td>
                                        <td>{{ child.description }}</td>
                                        <td>{{ child.slug }}</td>
                                        <td>0</td>
                                        <td class="text-right">
                                            <button  @click="deleteCategory(child.id, index)" class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <a class="btn btn-primary" v-bind:href="child.editlink">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </template>
                           </template>
                        </tbody> !-->
                    </div>
                    <div v-if="!categories.length" class="text-center p-3 text-muted">
                        <h5>No Results</h5>
                        <p>Looks like you have not added any users yet!</p>
                    </div>
                </div>
                <div class="text-center p-4 text-muted" v-else>
                    <h5>Loading</h5>
                    <p>Please wait, data is being loaded...</p>
                </div>
            </div>
        </div>
        <div class="text-center" v-if="categories.length && total > categories.length">
            <button v-bind:disabled="loading" @click="loadCategories" class="btn btn-primary"><span v-if="loading">Loading <i class="fas fa-spinner fa-spin"></i></span><span v-else>Load More</span></button>
        </div>        
    </div>
</div>
</template>

<script>
import CategoryTableTree from './CategoryTableTree.vue'
export default {
    components: {
        CategoryTableTree
    },
    data() {
        return {
            categories: [],
            total: 0,
            loading: false,
            loadingmore: false,
            query: '',
            url: ''            
        }
    },
    mounted() {            
        let query = location.search.split('query=')[1];
        if(query !== undefined) {
            this.query = query;
        }
                            
        this.url = BaseUrl('admin/category');       
        this.loadCategories();
    },
    methods: {
        loadCategories() {            
            let _this = this;            
            _this.loading = true;
            axios.get(_this.url).then((res) => {                
                _this.categories =  res.data;
                _this.total = res.data.total;
                _this.loading = false;
                // _this.url = res.data.next_page_url;
            }).catch((err) => {
                _this.loading = false;
            });
        },

        deleteCategory(categoryId) {            
            let _this = this;
            this.$iosConfirm({
                title: 'Are you sure?',
                text: 'The category will be permanently deleted. Proceed?'
            }).then(function() {
                axios.delete(_this.$parent.MakeUrl('admin/category/'+categoryId)).then((res) => {                    
                    _this.loadCategories();                    
                }).catch(error => {
                    _this.$iosAlert({
                        'title': 'Error',
                        'text': error.response.data.message
                    });
                });                
            });
        } 
    
    }
}
</script>