<template>
  <div>
    <!-- Your component content goes here -->

    <div>
      <!-- Your component content goes here -->
      {{ "Schedule shows here! " }}<br />{{
        "> Reschedule feature implementation"
      }}<br />{{ "> Info button to show the topic of the meeting." }}<br />{{
        "> Add a button to cancel the meeting"
      }}<br />{{ "> Review button if the meeting has been done "
      }}<br /><br /><br /><br />

      {{ "Lecturer Schedule shows here! " }}<br />{{
        "> Reschedule feature implementation"
      }}<br />{{ "> Info button to show the topic of the meeting." }}<br />{{
        "> Add a button to cancel the meeting"
      }}<br />
      <br /><br /><br />
      {{
        "Extra stuff to do: "
      }}<br />{{
        "> Maybe need to add a review button in the lecturer details page to view reviews of the lecturer."
      }}<br />
    </div>
  </div>
</template>
<script>
export default {
  name: "Scheduling",
  data() {
    return {
      // Your data properties go here
    };
  },
  methods: {
    // Your component methods go here
  },
  mounted() {
    // Code to run when the component is mounted goes here
  },
};
</script>

<style scoped>
/* Your component styles go here */
</style>
