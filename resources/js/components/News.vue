<template>
    <div>
        <h1>News</h1>
        <div v-if="loading" class="loading">
            Loading...
        </div>
        <div v-if="error" class="alert alert-danger" role="alert">
            {{ error }}
        </div>

        <div v-if="news">
            <div v-for="{ id,title,likes, content,created_at } in news" class="news-item mb-3 p-3 shadow">
                <h2 class="news-title">{{ title }}</h2>
                <div class="news-content">{{content}}</div>
                <div class="news-footer text-right">
                    <span class="like" title="Like" :class="{'liked':isLiked(likes)}" @click="like(id)">
                       {{likes.length}} <i class="fas fa-heart"></i>
                    </span>
                    &nbsp;
                    <span class="news-date">{{created_at}}</span>
                </div>
            </div>
        </div>
        <nav aria-label="..." v-if="news">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="#" v-if="prevPage" @click.prevent="goToPrev">&laquo;</a>
                    <span v-else class="page-link">&laquo;</span>
                </li>
                <li class="page-item" :class="{'active' : n === meta.current_page}" v-for="n in meta.last_page">
                    <a class="page-link" href="#" v-if="meta.current_page !== n" @click.prevent="getPage(n)">{{n}}</a>
                    <span v-else class="page-link">{{n}}</span>
                </li>

                <li class="page-item">
                    <a class="page-link" href="#" v-if="nextPage" @click.prevent="goToNext">&raquo;</a>
                    <span v-else class="page-link">&raquo;</span>
                </li>
            </ul>
        </nav>
    </div>

</template>

<script>
    import axios from 'axios';

    const getNews = (page, callback) => {
        const params = {page};

        axios
            .get('/api/news/get', {params})
            .then(response => {
                console.log(response.data);
                callback(null, response.data);
            }).catch(error => {
            callback(error || error.response.data)
        });
    };

    export default {
        name: "News",
        data() {
            return {
                news: null,
                loading: true,
                error: false,
                meta: null,
                links: {
                    first: null,
                    last: null,
                    next: null,
                    prev: null,
                },
            }
        },
        computed: {
            nextPage() {
                if (!this.meta || this.meta.current_page === this.meta.last_page) {
                    return;
                }

                return this.meta.current_page + 1;
            },
            prevPage() {
                if (!this.meta || this.meta.current_page === 1) {
                    return;
                }

                return this.meta.current_page - 1;
            }
        },
        beforeRouteEnter(to, from, next) {

            getNews(to.query.page, (err, data) => {
                next(vm => {
                    vm.setData(err, data);
                });
            });
        },
        beforeRouteUpdate(to, from, next) {
            this.loading = true;
            this.news = this.links = this.meta = null
            getNews(to.query.page, (err, data) => {
                this.setData(err, data);
                next();
            });
        },

        methods: {
            goToNext() {
                this.$router.push({
                    query: {
                        page: this.nextPage,
                    },
                });
            },
            goToPrev() {
                this.$router.push({
                    name: 'home',
                    query: {
                        page: this.prevPage,
                    }
                });

            },
            getPage(n = 1) {
                this.$router.push({
                    name: 'news',
                    query: {
                        page: n
                    }
                });
            },
            setData(err, {data: data, current_page, last_page}) {
                if (err) {
                    this.error = err.toString();
                    this.loading = false;
                } else {
                    this.news = data;
                    this.meta = {
                        current_page: current_page,
                        last_page: last_page,
                    };
                    this.loading = false;
                }
            },

            like(id) {
                if (!Laravel.User.id) {
                    return;
                }

                axios
                    .post('api/like', {id: id, type: 'news'})
                    .then(response => {
                        console.log(response);
                        let el = this.news.find(el => el.id === id);

                        if (response.data.success) {
                            if (response.data.action === 'added') {
                                el.likes.push({user_id: Laravel.User.id});
                            } else {
                                let like = el.likes.findIndex(el => el.user_id === Laravel.User.id);
                                el.likes.splice(like, 1);
                            }
                        } else {
                            alert(response.data.error);
                        }
                    }).catch(error=>{
                        alert(error);
                })
            },

            isLiked(likes) {
                return likes.find(item => item.user_id === Laravel.User.id);
            }
        }

    }
</script>

<style scoped>

    h2.news-title {
        color: #87cc2d;
    }

    .news-footer .news-date {
        font-size: .7em;
    }

    .like {
        cursor: pointer;
    }

    .like.liked {
        color: #87cc2d;
    }
</style>
