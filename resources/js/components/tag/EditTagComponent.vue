<template>
   <div class="row">
        <div class="col-12">
            <div class="alert alert-primary" v-if="message">
                {{ message }}
            </div>        
            <div class="card">
                <div class="card-header">                
                    <h4>Add a New Tag</h4>
                </div>
                <div class="card-body">
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tag</label>
                        <div class="col-sm-12 col-md-7">
                            <input v-bind:class="{'is-invalid': errors.name}" type="text" v-model="name" class="form-control" placeholder="Tag name">
                            <div class="invalid-feedback" v-if="errors.name">
                                <p>{{ errors.name[0] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button v-bind:disabled="loading" @click="updateTag" class="btn btn-primary"><span v-if="loading">Updating</span><span v-else>Update</span></button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div> 
</template>


<script>
export default {
    props: {
        tag: {
            type: String
        }
    },
    data() {
        return {   
            name: this.getTagdata('name'),
            errors: [],        
            message: '',
            loading: false       
        }
    },
    methods: {  
        getTagdata(key) {
            return JSON.parse(this.tag)[key];            
        },     
        updateTag(){
            let _this = this;
            _this.errors = [];
            _this.message = '';
            _this.loading = true;
            axios.put(this.$parent.MakeUrl('admin/tag/'+this.getTagdata('id')), {'name': this.name}).then((res) => {
                _this.loading = false;                
                _this.message = 'Tag has been successfully updated!';
            }).catch((err) => {
                _this.errors = err.response.data.errors;
                _this.loading = false;
            });
        }
    },   
    
}
</script>