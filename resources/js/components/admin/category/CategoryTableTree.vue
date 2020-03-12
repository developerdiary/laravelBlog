<template>
    <li class="tree-view-category-list">
        <a v-bind:href="node.editlink">{{ node.name }}</a>
        <button   @click.capture.stop="deleteCategory(node.id)" class="btn btn-danger">
            <i class="fa fa-trash"></i>
        </button>        
        <ul v-if="node.children && node.children.length">                
            <node v-for="child in node.children" :node="child" v-bind:key="child.id"></node>
        </ul>    
    </li>

</template> 

<script>
export default {
    name: "node",
    props: {
        node: Object,
    },
    methods: {
        deleteCategory(categoryId){
            this.$parent.deleteCategory(categoryId);
        }
    },
};
</script>
<style scoped>
.tree-view-category-list .btn{
    padding: .0rem .3rem;
    font-size: 10px;
}
</style>