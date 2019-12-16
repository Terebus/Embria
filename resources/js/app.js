/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from "vue-router";
import VModal from 'vue-js-modal';


import News from './components/News';
import Photos from './components/Photos';
import Dashboard from './components/Dashboard';

import DashboardNews from './components/Dashboard/news/get';
import DashboardNewsEdit from './components/Dashboard/news/edit';
import DashboardNewsAdd from './components/Dashboard/news/new';

import DashboardPhotos from './components/Dashboard/photos/get';
import DashboardPhotosAdd from './components/Dashboard/photos/add';

Vue.use(VueRouter);
Vue.use(VModal,{dynamic:true,injectModalsContainer:true});

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'news',
            component: News
        },
        {
            path: '/photos',
            name: 'photos',
            component: Photos
        },
        {
            path: '/dashboard',
            name: 'dashboard',
            component: Dashboard,
            children: [
                {
                    path: 'news',
                    name: 'dashboard.news',
                    meta:{
                        root:true
                    },
                    component: DashboardNews,
                    children: [
                        {
                            path: '/dashboard/news/:id/edit',
                            name: 'dashboard.news.edit',
                            component: DashboardNewsEdit
                        },
                        {
                            path: '/dashboard/news/add',
                            name: 'dashboard.news.add',
                            component: DashboardNewsAdd
                        }
                    ]
                },
                {
                    path: 'photos',
                    name:'dashboard.photos',
                    component:DashboardPhotos,
                    meta: {
                        root:true
                    },
                    children: [
                        {
                            path: 'add',
                            name: 'dashboard.photos.add',
                            component: DashboardPhotosAdd
                        }
                    ]
                }

            ]
        },

    ]
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    router,
}).$mount('#app');
