<template>
    <div class="card artwork-card">
        <div class="card-image">
            <figure class="image is-4by3">
                <img :src="artwork.image" alt="Chargement..."/>
            </figure>
        </div>
        <div class="card-content">
            <div class="media">
                <div class="media-content">
                    <p class="title is-4">
                        <span class="is-capitalized">{{ artwork.title }}</span>
                        <span v-if="artwork.creationDate">({{ artwork.creationDate }})</span>
                    </p>
                    <p class="subtitle is-6">{{ artwork.authorName || 'Auteur inconnu' }}</p>
                    <a :href="artwork.descriptionUrl" v-if="artwork.descriptionUrl" target="_blank">Accéder à la page Wikipédia</a>
                </div>
            </div>
            <router-link :to="{ name: 'artwork', params: { id: artwork.apiId } }">
                <button class="button is-light is-fullwidth">En savoir plus</button>
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        artwork: { type: Object, default: {} }
    }
}
</script>
