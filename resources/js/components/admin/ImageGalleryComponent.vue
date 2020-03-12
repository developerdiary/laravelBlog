<template>
    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gallery</label>                    
        <div  class="col-sm-12 col-md-7">
            <div>
                <input type="file" name="images[]" @change="imagesAdd" multiple ref="file-input" accept="image/x-png,image/gif,image/jpeg">
            </div> 
            <ul class="image-container">
                <li v-for="(img, key) in image" :key="img.id">
                    <img  class="img-pre" :src="img">
                    <!-- <img  class="img-pre" :src="img" v-else> -->
                    <button class="btn btn-danger" v-show="image" @click="removeImage(key)">Remove</button>
                </li>
            </ul>            
        </div>                
    </div>    
</template>

<script>

export default { 
    props: {
        gallery: {
            type: Array
        }
    },   
    data() {
        return {
            images: {},
            image: []
        }
    }, 
    mounted() {
        if(this.gallery){
            this.gallery.forEach((g, index) => {                                
                this.image.push(g.name);
                // this.images[index] = g.name;
            });
        }
    }, 
    methods: {
        imagesAdd(e){
            var files = e.target.files || e.dataTransfer.files;
            this.images = [];
            Array.prototype.push.apply(this.images, files);
            if (!this.images.length)
                return;

            this.createImage(this.images);

            const fileInput = this.$refs['file-input'];            
            fileInput.value = '';

        },
        createImage(file){
            for (var i = 0; i < file.length; i++) {
                var reader = new FileReader();
                var vm = this;
                reader.onload = (e) => {
                    vm.image.push(e.target.result);                    
                };                
                reader.readAsDataURL(file[i]);
            }
            this.updateGallery();

        },
        removeImage(key){            
            this.image.splice(key, 1);
            // this.images.splice(key, 1);
            this.updateGallery();
        },
        updateGallery(){            
            this.$parent.updateGallery(this.image);
        }

    }
}
</script>


<style lang="scss" scoped>

.image-container {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    margin: 0;
    padding: 0;
}
.image-container li {
    display: list-item;
    list-style: none;
    padding: 10px;
    width: 33.33%;
}

.image-container li img{
    width: 100%;
}


</style>