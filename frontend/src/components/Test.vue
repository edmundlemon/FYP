<template>
    <div>
        <h1>Welcome to my Vue component!</h1>
        <p>This is a test component.</p>
    </div>
</template>

<script>
export default {
    name: 'Test',
    data() {
        return {
            message: 'Hello, world!'
        }
    },
    methods: {
        greet() {
            console.log(this.message);
        }
    },
    mounted() {
        this.greet();
    }
}
</script>

<style scoped>
h1 {
    color: blue;
}
p {
    font-size: 18px;
}
</style>