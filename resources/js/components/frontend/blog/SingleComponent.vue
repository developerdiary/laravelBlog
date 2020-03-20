<template>
    <div class="blog single">
        <header class="masthead" style="background-image: url('img/post-bg.jpg')">
            <div class="overlay"></div>
            <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                <div class="post-heading">
                    <h1>{{ single.title }}</h1>
                    <h2 class="subheading">{{ single.subtitle }}</h2>
                    <span class="meta">Posted by
                    <a href="#">Start Bootstrap</a>
                    on August 24, 2019</span>
                </div>
                </div>
            </div>
            </div>
        </header>  
        <article>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-10 mx-auto">
                        <div v-html="single.body"></div>
                    </div>
                </div>
            </div>
        </article>
    </div>
</template>


<script>
export default {
    props: {
        post: {
            type: String
        }
    },
    data() {
        return {
            single: JSON.parse(this.post),
            // total: 0,
            // loading: false,
            // loadingmore: false,
            // query: '',
            // url: ''
        }
    },
    mounted() {            
        // let query = location.search.split('query=')[1];
        // if(query !== undefined) {
        //     this.query = query;
        // }
        // this.url = BaseUrl('blog?q='+this.query);        
        // this.loadPosts();
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