// Use VueRouter
import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

// Import views
import HomeView from '../views/Home.vue'
import DetailsView from '../views/Details.vue'

// Create the router
export default new VueRouter({
    mode: 'history',
    routes: [
        {
            name: 'home',
            path: '/',
            component: HomeView
        },
        {
            name: 'details',
            path: '/details',
            component: DetailsView
        }
    ]
})