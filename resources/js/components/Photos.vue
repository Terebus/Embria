<template>
    <div>
        <h2>Photos</h2>
        <div v-if="loading">Loading...</div>
        <div id="photo-grid" v-if="images">

            <img v-for="image in images" v-bind:src="getImageURL(image.file_name)" v-on:click="openImage(image)"/>

        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import ImageModal from '../components/Modal';

    export default {
        name: "Photos",

        data() {
            return {
                images: false,
                loading: true
            }
        },
        mounted() {
            this.getPhotos();
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


            openImage(image) {
                this.$modal.show(ImageModal, {
                    src: this.getImageURL(image.file_name),
                    image: image
                }, {
                    width: '60%',
                    height: 'auto',
                });
            }
        },

    }
</script>

<style scoped>
    #photo-grid {
        overflow: hidden;
    }

    #photo-grid img {
        width: auto;
        height: auto;
        max-height: 150px;
        max-width: 150px;
        float: left;
        border-radius: 4px;
        margin: 0 10px 10px 10px;
        cursor: pointer;
    }
</style>
