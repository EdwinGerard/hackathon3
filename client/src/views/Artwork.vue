<template>
    <section class="details-container">
        <!-- Loading -->
        <div class="pageloader" :class="{ 'is-active': isLoading }">
            <span class="title" v-html="'<br/>' + (loadingMessage || 'Chargement...')"></span>
        </div>

        <div class="details-left">
            <div class="content">
                <!-- Lieu où ce trouve cette oeuvre -->
                <div class="location">
                    <span>{{ artwork.locationName }}<span v-if="artwork.locationCity"> à {{ artwork.locationCity }}</span></span>
                </div>
    
                <!-- Titer de l'oeuvre -->
                <div class="title-artwork">
                    <h1 class="title is-2">
                        {{ artwork.title || 'Titre inconnu' }}
                        <small v-if="artwork.creationDate">({{ artwork.creationDate }})</small>
                    </h1>
                    <h2 class="subtitle is-5">{{ artwork.authorName }}</h2>
                </div>
    
                <!-- Description de l'oeuvre -->
                <p class="description-artwork" v-html="artwork.description"></p>
    
                <!-- Autres liens (Buttons) -->
                <div class="field is-grouped">
                    <p class="control">
                        <a class="button is-link is-radiusless" :href="artwork.descriptionUrl" target="_blank">Wikipédia</a>
                    </p>
                    <p class="control">
                        <a class="button is-light is-radiusless" href="#" target="_blank">A propos de l'auteur</a>
                    </p>
                </div>

                <!-- Autres liens (Urls) -->
                <p>
                    <a :href="adminEditUrl" target="blank">Modifier la fiche de cette œuvre</a><br/>
                    <router-link :to="{ name: 'home' }"><a>Retourner à la recherche des œuvres</a></router-link>
                </p>
            </div>
        </div>
        <div class="details-right" v-bind:style="{ backgroundImage: 'url(' + this.artwork.image +')' }"></div>
    </section>
</template>

<script>
export default {
    name: 'artwork',
    data: () => ({
        artworkId: 0,
        artwork: {},
        loadingMessage: null,
        isLoading: true
    }),
    computed: {
        adminEditUrl() {
            return 'http://localhost:8000/works/editShow/' + this.artwork.id
        }
    },
    beforeCreate: function() {
        console.log(this.$router)
        this.artworkId = parseInt(this.$route.params.id)
        fetch('http://localhost:8000/works/id/' + this.artworkId)
        .catch(err => {
            this.loadingMessage = err.message
            this.loadingMessage += '<br/><a href="/">Retourner en arrière</a>'
        })
        .then(res => res.json())
        .then(({ work }) => {
            this.artwork = work
            if (this.artwork.image === 'https://api.art.rmngp.fr/v1/images/408/503545/xxl?t=USMLv3rs7PLOTYc1mxsmdQ')
                this.artwork.image = '/static/easter-eggs/joconde.gif'
            this.isLoading = false
        })
    }
}
</script>