<template>
    <div>

        <div v-if="this.$route.meta.root">
            <router-link :to="{name:'dashboard.news.add'}" class="text-success">
                New post&nbsp;
                <i class="fas fa-plus-circle"></i>
            </router-link>
            <table class="table-responsive table w-100">
                <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="news" v-for="item in news">
                    <td>{{item.id}}</td>
                    <td>{{item.title}}</td>
                    <td>{{item.created_at}}</td>
                    <td>{{item.updated_at}}</td>
                    <td>
                        <router-link :to="{name:'dashboard.news.edit',params:{id:item.id}}" class="text-primary">
                            <i class="fas fa-edit"></i>
                        </router-link>
                        <br/>
                        <a href="" @click.prevent="delNews(item)" :key="item.id" class="text-danger">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                <tr v-else>
                    <td colspan="4">Loading...</td>
                </tr>
                </tbody>
            </table>
            <nav aria-label="..." v-if="news">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" v-if="current_page !==1" @click.prevent="getPage(current_page-1)">&laquo;</a>
                        <span v-else class="page-link">&laquo;</span>
                    </li>
                    <li class="page-item" :class="{'active' : n === current_page}" v-for="n in last_page">
                        <a class="page-link" href="#" v-if="current_page !== n" @click.prevent="getPage(n)">{{n}}</a>
                        <span v-else class="page-link">{{n}}</span>
                    </li>

                    <li class="page-item">
                        <a class="page-link" href="#" v-if="current_page!==last_page"
                           @click.prevent="getPage(current_page+1)">&raquo;</a>
                        <span v-else class="page-link">&raquo;</span>
                    </li>
                </ul>
            </nav>
        </div>
        <router-view></router-view>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "news",
        data() {
            return {
                news: false,
                current_page: 1,
                last_page: 0
            }
        },


        mounted() {

        },
        created() {
            this.getNews();
        },
        methods: {
            delNews(item) {
                if (confirm('Are you sure?')) {
                    axios
                        .post('/api/news/delete', {id: item.id})
                        .then(response => {
                            if (response.data.success) {
                                this.news.splice(this.news.indexOf(item), 1);
                            } else {
                                alert(response.data.error);
                            }
                        });
                }
            },
            getPage(n = 1) {
                console.log(n);
                this.getNews(n);
            },
            getNews(n = 1) {
                axios
                    .get('/api/news/get', {params: {page: n}})
                    .then(response => {
                        //console.log(response.data);
                        this.news = response.data.data;
                        this.current_page = response.data.current_page;
                        this.last_page = response.data.last_page;
                    });
            }
        }
    }
</script>

<style scoped>

</style>
