<template>
    <div>
        <h2>Edit post</h2>
        <div v-if="error" class="alert alert-danger" role="alert">
            {{ error }}
        </div>

        <div v-if="success" class="alert alert-success" role="alert">
            {{ success }}
        </div>
        <form v-if="news" v-on:submit.prevent="Update">

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" v-model="news.title">
            </div>
            <div class="form-group">
                <label for="text">Password</label>
                <textarea class="form-control" id="text" v-model="news.content"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <div v-else>Loading...</div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: "editNews",
        data() {
            return {
                news: null,
                error: false,
                success: false
            }
        },
        methods: {
            Update() {
                this.success = this.error = false;
                axios
                    .post('/api/news/update', this.news)
                    .then(response => {
                        if (response.data.success) {
                            this.success = 'Post updated';
                        } else {
                            this.error = response.data.error;
                        }
                    }).catch(error => {
                    this.error = error.data;
                });
            }
        },
        mounted() {
            axios
                .get('/api/news/get', {params: {id: this.$route.params.id}})
                .then(response => {
                    this.news = response.data;

                });
        }
    }

</script>

<style scoped>

</style>
