<template>
    <div>

        <div v-if="this.$route.meta.root">
            <router-link :to="{name:'dashboard.photos.add'}" class="text-success">
                Add new photo
                <i class="fas fa-plus-circle"></i>
            </router-link>
            <div v-if="loading">Loading..</div>
            <div id="photo-grid" v-if="images">
                <div class="image" v-for="image in images">
                    <img v-bind:src="getImageURL(image.file_name)"/>
                    <div class="image-footer text-right">
                         <span class="like">
                                {{image.likes.length}} <i class="fas fa-heart"></i>
                        </span>
                        &nbsp;&nbsp;
                        <a href="" @click.prevent="delPhoto(image)" :key="image.id" class="text-danger">
                            <i class="fas fa-trash-alt"></i>
                        </a>

                    </div>
                </div>
            </div>

        </div>
        <router-view v-else></router-view>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: "get",
        data() {
            return {
                images: false,
                loading: true,
            }
        },
        methods: {
            getImageURL(fileName) {
                return window.location.protocol + '//' + window.location.hostname + '/images/' + fileName;
            },
            getPhotos() {
                axios
                    .get('/api/photos/get')
                    .then(response => {
                        this.images = response.data;
                        this.loading = false;
                        console.log(this.images);
                    })
                    .catch(error => {
                        console.log(error.error);
                    })
            },
            delPhoto(image){
                if (confirm('Are you sure?')){

                    axios
                        .post('/api/photos/delete', {id: image.id})
                        .then(response => {
                            if (response.data.success) {
                                this.images.splice(this.images.indexOf(image), 1);
                            } else {
                                alert(response.data.error);
                            }
                        });
                }
            }
        },
        created() {
            this.getPhotos();
        }
    }
</script>

<style scoped>
    #photo-grid {
        overflow: hidden;
    }

    #photo-grid .image {
        float: left;
        width: 200px;
        height: auto;
        border-radius: 4px;
        margin: 0 10px 10px 10px;
    }

    #photo-grid .image img {
        width: 100%;
        height: auto;
    }

    #photo-grid .image .image-footer{
        background: #eeeeee;
    }
</style>
