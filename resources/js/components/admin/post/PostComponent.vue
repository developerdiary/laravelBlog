<template>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Post <span v-if="total">({{ total }})</span></h4>
                <div class="card-header-action">
                    <a v-bind:href="$parent.MakeUrl('admin/post/create')" class="btn btn-primary">Add    <i class="fas fa-plus"></i></a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive table-invoice" v-if="!loading">
                    <table class="table table-striped" v-if="posts.length">
                        <tbody>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Published Date</th>
                                <th></th>
                            </tr>
                            <tr v-for="(post, index) in posts" v-bind:key="index">
                                <td>{{ post.title }}</td>
                                <td>
                                    <div v-for="(category, index) in post.category"  v-bind:key="index">
                                        {{ category.name }}
                                    </div>                                    
                                </td>
                                <td>{{ post.created_at }}</td>
                                <td class="text-right">
                                    <button  @click="deletePost(post.id, index)" class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <a class="btn btn-primary" v-bind:href="post.editlink">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-if="!posts.length" class="text-center p-3 text-muted">
                        <h5>No Results</h5>
                        <p>Looks like you have not added any posts yet!</p>
                    </div>
                </div>
                <div class="text-center p-4 text-muted" v-else>
                    <h5>Loading</h5>
                    <p>Please wait, data is being loaded...</p>
                </div>
            </div>
        </div>
        <div class="text-center" v-if="posts.length && total > posts.length">
            <button v-bind:disabled="loading" @click="loadPosts" class="btn btn-primary"><span v-if="loading">Loading <i class="fas fa-spinner fa-spin"></i></span><span v-else>Load More</span></button>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            posts: [],
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
        this.url = BaseUrl('admin/post?q='+this.query);        
        this.loadPosts();
    },
    methods: {
        loadPosts() {
            let _this = this;     
            axios.get(_this.url)
            .then(function (response) {                                
                _this.posts =  _this.posts.concat(response.data.data);
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
        deletePost(postId, index) {
            let _this = this;
            this.$iosConfirm({
                title: 'Are you sure?',
                text: 'The post and their associated data will be permanently deleted. Proceed?'
            }).then(function() {
                axios.delete(_this.$parent.MakeUrl('admin/post/'+postId)).then((res) => {
                    _this.posts.splice(index, 1);
                    _this.total = _this.total - 1;
                    _this.loadPosts();
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
