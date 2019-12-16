<template>
    <div>
        <img :src="src">
        <div class="image-footer text-center">
        <span class="like" title="Like">
                  <span class="like" title="Like" :class="{'liked':isLiked(image.likes)}" @click="like(image.id)">
                       {{image.likes.length}} <i class="fas fa-heart"></i>
                    </span>
                </span>
        </div>
    </div>

</template>

<script>
    import axios from "axios";

    export default {
        name: "Modal",
        props: ['src', 'image'],
        methods: {
            like(id) {
                if (!Laravel.User.id) {
                    return;
                }

                axios
                    .post('api/like', {id: id, type: 'photo'})
                    .then(response => {
                        ;

                        if (response.data.success) {
                            if (response.data.action === 'added') {
                                this.image.likes.push({user_id: Laravel.User.id});
                            } else {
                                let like = this.image.likes.findIndex(el => el.user_id === Laravel.User.id);
                                this.image.likes.splice(like, 1);
                            }
                        } else {
                            alert(response.data.error);
                        }
                    }).catch(error => {
                    alert(error);
                })
            },

            isLiked(likes) {
                return this.image.likes.find(item => item.user_id === Laravel.User.id);
            }
        }
    }
</script>

<style scoped>
    .v--modal-box img {
        width: 100%;
        height: auto;
    }

    .like {
        cursor: pointer
    }

    .like.liked {
        color: #87cc2d;
    }
</style>
