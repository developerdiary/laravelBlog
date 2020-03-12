<template>
    <div class="container">
        <div class="row"  v-if="posts.length">
            <div class="col-lg-8 col-md-10 mx-auto">                
                <div v-for="(post, index) in posts" class="post-preview" v-bind:key="index">
                    <a href="post.html">
                        <h2 class="post-title">
                            {{ post.title }}
                        </h2>
                        <h3 class="post-subtitle">
                            {{ post.subtitle }}
                        </h3>
                    </a>
                    <p class="post-meta"><span>{{ post.updated_at | moment("dddd, Do MMMM YYYY") }}</span></p>                    
                    <hr v-if="(posts.length -1 ) != index">                 
                </div>                
                <!-- Pager -->

                <div class="clearfix" v-if="posts.length && total > posts.length">
                    <a @click="loadPosts" class="btn btn-primary float-right"  href="javascript:void(0)">Older Posts &rarr;</a>
                </div>                
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
        this.url = BaseUrl('blog?q='+this.query);        
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
        }
    }
}
</script>

<style scoped>

</style>