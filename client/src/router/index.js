// Use VueRouter
import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

// Import views
import HomeView from '../views/Home.vue'
import Artwork from '../views/Artwork.vue'

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
            name: 'artwork',
            path: '/artworks/:id',
            component: Artwork
        }
    ]
})