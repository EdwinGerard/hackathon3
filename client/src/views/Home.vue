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

                <!-- Load more -->
                <button class="button is-light is-fullwidth" @click="loadMoreResults()" :class="{ 'is-loading': isLoadingMoreResults }">Charger plus de résultats</button>
            </div>
        </section>
    </section>
</template>

<script>
import NavBar from '../components/NavBar.vue'
import HeaderSearch from '../components/HeaderSearch.vue'
import ArtworkCard from '../components/ArtworkCard.vue'

export default {
    name: 'app',
    data: () => ({
        searchInput: 'Hello from the other side',
        isLoadingMoreResults: false
    }),
    methods: {
        loadMoreResults() {
            this.isLoadingMoreResults = true
            setTimeout(() => {
                this.isLoadingMoreResults = false
            }, 2000)
        }
    },
    components: {
        NavBar,
        HeaderSearch,
        ArtworkCard
    }
}
</script>