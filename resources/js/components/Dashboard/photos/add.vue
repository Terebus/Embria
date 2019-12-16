<template>
    <div>
        <h3>Add new photo</h3>
        <div v-if="error" class="alert alert-danger" role="alert">
            {{ error }}
        </div>

        <div v-if="success" class="alert alert-success" role="alert">
            {{ success }}
        </div>

        <form v-on:submit.prevent="Save">
            <div class="form-group">
                <label for="file">Photo</label>
                <input type="file" class="form-control" id="file" ref="file" accept="image/*" @change="handleFile">
            </div>
            <div class="form-group" v-if="image">
                <img v-bind:src="image">
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</template>

<script>
    export default {
        name: "add",
        data() {
            return {
                error: false,
                success: false,
                image: null,
                file: null
            }
        },
        methods: {
            handleFile() {
                this.file = this.$refs.file.files[0];
                console.log(this.file);
                const app = this;
                let reader = new FileReader();
                reader.onload = function (e) {
                    app.image = e.target.result;
                };
                reader.readAsDataURL(this.file);
            },

            Save() {
                if (!this.file) {
                    return;
                }
                let formData = new FormData();
                formData.append('file',this.file);

                axios
                    .post('/api/photos/add', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(response => {
                    if (response.data.success) {
                        this.success = 'Image has been added';
                        this.image=null;
                        this.file = null;
                    } else {
                        this.error = response.data.error;
                    }
                })
                    .catch(error => {
                        this.error = error.error
                    });
            }
        }
    }
</script>

<style scoped>
    div.form-group img {
        width: 100%;
        height: auto;
        max-width: 300px;
    }
</style>
