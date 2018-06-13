<template>
    <div>
        {{ welcomeMessage }}
    </div>
</template>

<script>
export default {
    name: 'app',
    data: () => ({
        welcomeMessage: 'Welcome'
    })
}
</script>