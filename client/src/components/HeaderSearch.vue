<template>
    <section class="header-banner">
        <div class="banner">
            <div class="overlay">
                <div class="container">
                    <!-- Search bar -->
                    <label class="label has-text-white is-size-5">Rechercher une œuvre</label>
                    <div class="control is-large">
                        <input
                            type="text"
                            class="input is-large has-text-centered search-input"
                            placeholder="Rechercher une œuvre..."
                            v-model="search"
                        />
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    props: {
        search: { type: String, default: 'Recherchez une œuvre par son nom...' }
    }
}
</script>
