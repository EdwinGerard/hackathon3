<template>
    <section>
        <!-- Navbar -->
        <nav class="navbar" role="navigation" aria-label="main navigation">
            <div class="container">
                <div class="navbar-brand">
                    <a class="navbar-item" href="https://bulma.io">
                        <img src="https://bulma.io/images/bulma-logo.png" alt="Bulma: a modern CSS framework based on Flexbox" width="112" height="28">
                    </a>

                    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false">
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                    </a>
                </div>
            </div>
        </nav>

        <!-- Header -->
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
                                v-model="searchInput"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Search results -->
        <section class="section">
            <div class="container">
                test
            </div>
        </section>
    </section>
</template>

<script>
export default {
    name: 'app',
    data: () => ({
        searchInput: 'Hello from the other side'
    })
}
</script>