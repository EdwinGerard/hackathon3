<template>
    <section>
        <nav-bar></nav-bar>
        <!-- TODO: Comment faire pour que lorsque qu'on modifie dans HeaderSearch.vue ça modifie la valeur dans cette vue aussi ? -->
        <header-search v-bind:search="searchInput"></header-search>
        
        <!-- Search results -->
        <section class="section">
            <div class="container">
                <div class="columns is-multiline">
                    <div class="column is-3" v-for="n in 12" :key=n>
                        <artwork-card></artwork-card>
                    </div>
                </div>
            </div>
        </section>
    </section>
</template>

<script>
import NavBar from '../components/NavBar.vue'
import HeaderSearch from '../components/home/HeaderSearch.vue'
import ArtworkCard from '../components/ArtworkCard.vue'

export default {
    name: 'app',
    data: () => ({
        searchInput: 'Hello from the other side'
    }),
    components: {
        NavBar,
        HeaderSearch,
        ArtworkCard
    }
}
</script>