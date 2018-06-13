<template>
    <section>
        <!-- Navbar -->
        <!-- Header -->
        <div class="large-header">

        </div>
        <!-- Search bar -->
        <!-- Search results -->
        {{ welcomeMessage }}
    </section>
</template>

<script>
export default {
    name: 'app',
    data: () => ({
        welcomeMessage: 'Welcome'
    })
}
</script>