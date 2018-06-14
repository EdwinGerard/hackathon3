<template>
    <section class="details-container">
        <div class="details-left">
            <div class="content">
                <!-- Lieu où ce trouve cette oeuvre -->
                <div class="location">
                    <span>{{ artwork.locationName }} à {{ artwork.locationCity }}</span>
                </div>
    
                <!-- Titer de l'oeuvre -->
                <div class="title-artwork">
                    <h1 class="title is-2">
                        {{ artwork.title }}
                        <small>({{ artwork.creationDate }})</small>
                    </h1>
                    <h2 class="subtitle is-5">{{ artwork.authorName }}</h2>
                </div>
    
                <!-- Description de l'oeuvre -->
                <p class="description-artwork" v-html="artwork.description"></p>
    
                <!-- Autres liens -->
                <div class="field is-grouped">
                    <p class="control">
                        <a class="button is-light is-radiusless" href="#" target="_blank">A propos de l'auteur</a>
                    </p>
                    <p class="control">
                        <a :href="artwork.descriptionUrl" target="_blank">Ou accéder à la page Wikipédia...</a>
                    </p>
                </div>
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
        artwork: {}
    }),
    beforeCreate: function() {
        this.artworkId = parseInt(this.$route.params.id)
        fetch('http://localhost:8000/works/id/' + this.artworkId)
        .catch(console.error)
        .then(res => res.json())
        .then(({ work }) => {
            this.artwork = work
        })
    }
}
</script>