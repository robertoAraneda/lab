<template>
    <div>
        <h1>test</h1>
        <h2>{{ details }}</h2>
    </div>
</template>

<script>
export default {
    props: ['details'],
    data: () => ({}),
    created() {
        console.log(details)
    }
}
</script>

<style></style>
