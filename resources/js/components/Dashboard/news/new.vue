<template>
    <div>
        <h2>New post</h2>
        <div v-if="error" class="alert alert-danger" role="alert">
            {{ error }}
        </div>

        <div v-if="success" class="alert alert-success" role="alert">
            {{ success }}
        </div>
        <form v-on:submit.prevent="Save">
            <input type="hidden" v-model="news.author_id">
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
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: "editNews",
        data() {
            return {
                news: {
                    author_id: Laravel.User.id,
                    title: '',
                    content: ''
                },
                error: false,
                success: false
            }
        },
        methods: {
            Save() {
                this.success = this.error = false;
                axios
                    .post('/api/news/add', this.news)
                    .then(response => {
                        if (response.data.success) {
                            this.success = 'Post added';
                        } else {
                            this.error = response.data.error;
                        }
                    }).catch(error => {
                    this.error = error.data;
                });
            }
        },
        mounted() {

        }
    }

</script>

<style scoped>

</style>
