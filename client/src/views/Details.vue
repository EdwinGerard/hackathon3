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
                        <div class="control">
                            <a class="button is-light is-radiusless" href="#">A propos de l'auteur</a>
                        </div>
                        <div class="control">
                            <a :href="artwork.descriptionUrl" target="_blank">Ou accéder à la page Wikipédia</a>
                        </div>
                </div>
            </div>
            <div class="details-right" v-bind:style="{ backgroundImage: 'url(' + this.artwork.image +')' }"></div>
        </section>
</template>

<script>


export default {
    name: 'details',
    data: () => ({
        artwork: {
            "apiId": 204456,
            "collection": "Peintures",
            "periodStart": "XVIe siècle",
            "periodEnd": "XVIe siècle",
            "technique": "huile sur bois",
            "locationName": "Musée du Louvre",
            "locationCity": "Paris",
            "image": "https://api.art.rmngp.fr/v1/images/408/503545/xxl?t=USMLv3rs7PLOTYc1mxsmdQ",
            "title": "La Joconde",
            "description": "<p><i><b>La Joconde</b></i>, ou <i><b>Portrait de Mona Lisa</b></i>, est un tableau de Léonard de Vinci, réalisé entre 1503 et 1506, qui représente un portrait mi-corps, probablement celui de la florentine Lisa Gherardini, épouse de Francesco del Giocondo. Acquise par François <abbr class=\"abbr\" title=\"premier\">I<sup>er</sup></abbr>, cette peinture à l'huile sur panneau de bois de peuplier de <span>77 × 53 cm</span> est exposée au musée du Louvre à Paris. <i>La Joconde</i> est l'un des rares tableaux attribués de façon certaine à Léonard de Vinci.</p>\n<p><i>La Joconde</i> est devenue un tableau éminemment…</p>",
            "descriptionUrl": "https://fr.wikipedia.org/wiki/La Joconde",
            "date": "",
            "creationDate": "1503",
            "authorName": "Léonard de Vinci",
            "authorApiId": "17354"
        }
    })
}
</script>