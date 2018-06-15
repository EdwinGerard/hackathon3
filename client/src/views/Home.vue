<template>
    <section>
        <nav-bar></nav-bar>
        <!-- TODO: Comment faire pour que lorsque qu'on modifie dans HeaderSearch.vue ça modifie la valeur dans cette vue aussi ? -->
        <header-search
            v-on:input="updateSearchInput"
            v-on:search="search(searchInput)"
            v-bind:isLarge="(results.length === 0) && (searchInput.length === 0)"
            v-bind:isLoading="isLoading"
        ></header-search>
        
        <!-- Search results -->
        <section class="section" v-if="searchInput.length > 0">
            <div class="container">
                <!-- No result -->
                <div class="notification" v-if="!isLoading && results.length === 0">
                    Il n'y a aucun résultat disponible pour la recherche <b>{{ searchInput }}</b>.
                </div>

                <!-- Results -->
                <div class="columns is-multiline">
                    <div class="column is-3" v-for="result in results" :key="result.id">
                        <artwork-card v-bind:artwork="result"></artwork-card>
                    </div>
                </div>
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
        searchInput: '',
        results: [],
        isLoading: false,
        fetchAbortController: null
    }),
    methods: {
        updateSearchInput(value) {
            this.searchInput = value
        },
        search(value) {
            // Check if its a valid search
            if (value.length === 0) {
                this.results = []
                return
            }

            // If a request is already in progress, abort it
            if (this.fetchAbortController !== null)
                this.fetchAbortController.abort()

            // Update the state of the request
            this.isLoading = true
            this.fetchAbortController = new AbortController()
            const signal = this.fetchAbortController.signal

            // Do the request
            fetch('http://localhost:8000/works/search/' + value, { signal })
                .then(req => req.json())
                .then(({ works }) => {
                    this.results = []
                    delete works.totalMatch
                    
                    for (const key in works)
                        this.results.push(works[key])
                    
                    this.fetchAbortController = null
                    this.isLoading = false
                })
        }
    },
    components: {
        NavBar,
        HeaderSearch,
        ArtworkCard
    }
}
</script>