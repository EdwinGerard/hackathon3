<template>
    <section class="header-banner">
        <div class="banner" :class="{ 'is-large': isLarge }">
            <div class="overlay">
                <div class="container">
                    <!-- Search bar -->
                    <label class="label has-text-white is-size-5">Rechercher une œuvre</label>
                    <div class="control is-large" :class="{ 'is-loading': isLoading }">
                        <input
                            type="text"
                            class="input is-large has-text-centered search-input"
                            :class="{ 'is-loading': isLoading }"
                            placeholder="Rechercher une œuvre par son nom..."
                            v-on:input="updateValue($event.target.value)"
                            @keydown.13="$emit('search')"
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
        search: { type: String, default: null },
        isLoading: { type: Boolean, default: false },
        isLarge: { type: Boolean, default: true }
    },
    methods: {
        updateValue(value) {
            this.$emit('input', value)
        }
    }
}
</script>
