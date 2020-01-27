<template>
<div class="row" v-if="$parent.userCan('manage-users')">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Tags <span v-if="total">({{ total }})</span></h4>
                <div class="card-header-action">
                    <a v-bind:href="$parent.MakeUrl('admin/tag/create')" class="btn btn-primary">Add <i class="fas fa-plus"></i></a>
                </div>
            </div>
            <div class="card-body p-0">                
                <div class="table-responsive table-invoice" v-if="!loading">
                    <table class="table table-striped" v-if="tags.length">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>                                                            
                            <tr v-for="tag in tags" v-bind:key="tag.id">
                                <td>{{ tag.name }}</td>
                                <td class="text-right">
                                    <button  @click="deleteTag(tag.id, index)" class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <a class="btn btn-primary" v-bind:href="tag.editlink">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody> 
                    </table>
                    <div v-if="!tags.length" class="text-center p-3 text-muted">
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
        <div class="text-center" v-if="tags.length && total > tags.length">
            <button v-bind:disabled="loading" @click="loadTags" class="btn btn-primary"><span v-if="loading">Loading <i class="fas fa-spinner fa-spin"></i></span><span v-else>Load More</span></button>
        </div>        
    </div>
</div>
</template>

<script>
export default {
    data(){
        return {
            tags: [],
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
                            
        this.url = BaseUrl('admin/tag');       
        this.loadTags();
        
    },
    methods: {                      
        loadTags(){
            let _this = this;     
            axios.get(_this.url)
            .then(function (response) {                
                _this.tags =  _this.tags.concat(response.data.data);
                _this.total = response.data.total;
                _this.loading = false;
                _this.url = response.data.next_page_url;
            })
            .catch(function (error) {
                // handle error
                _this.loading = false;
                console.log(error);
            })
        },
        deleteTag(tagId, index){

            let _this = this;
            this.$iosConfirm({
                title: 'Are you sure?',
                text: 'The tag will be permanently deleted. Proceed?'
            }).then(function() {
                axios.delete(_this.$parent.MakeUrl('admin/tag/'+tagId)).then((res) => {                    
                    _this.loadTags();                    
                }).catch(error => {
                    _this.$iosAlert({
                        'title': 'Error',
                        'text': error.response.data.message
                    });
                });                
            });
            
        }
    },
}
</script>