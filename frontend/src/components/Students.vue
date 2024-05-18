<template>
    <div>
        <h1>Students</h1>
        <table>
            <tr>
                <td>Username</td>
                <td>{{ user.name }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ user.email }}</td>
            </tr>
        </table>
    </div>

    <Test></Test>
</template>


<script>

export default {
    name: 'Students',
    data() {
        return {
            // Your data properties go here
        };
    },
    methods: {
        // Your methods go here
    },
    mounted() {
        // Code to run when the component is mounted
    },
    components: {
        // Your child components go here
        
    },
};
</script>

<style scoped>
/* Your component-specific styles go here */
</style>