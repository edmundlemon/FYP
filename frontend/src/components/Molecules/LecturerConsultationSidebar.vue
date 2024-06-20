<template>
  <div class="lecturer-consultation-sidebar">
    <!-- Your sidebar content goes here -->

    <div class="h-full flex flex-col items-center mr-2">
      <div class="bg-gray-100 rounded-lg shadow-lg border border-gray-400">
        <h1 class="text-center font-bold text-4xl mt-5">
          Manage Consultations
        </h1>
        <ul class="h-fit py-5 space-y-3 p-3 w-full">
          <li
            class="p-2 flex flex-col border border-black w-full relative group flex font-bold text-xl jusitfy-center rounded-md transition-all duration-300 hover:bg-gray-200 ease-in-out"
            v-for="data in sidebarData"
          >
            <div class="flex flex-row items-center ml-2 p-1">
              <img class="w-6 h-6" :src="data.iconpath" alt="asd" />
              <h2
                class="ml-2 cursor-pointer hovereffect hover:text-white transition-all duration-300 ease-in-out"
                @click="$emit('ClickedOption', data.title)"
              >
                {{ data.title }}
              </h2>
            </div>
            <ul
              v-if="data.dropdown"
              class="hidden group-hover:flex flex-col whitespace-nowrap font-semibold text-xl pb-2 w-fit space-y-1 mt-2 w-full justify-center items-center rounded-lg shadow-lg"
            >
              <li v-for="dropdown in data.dropdown">
                <h3
                  class="transition-all rounded-lg cursor-pointer duration-300 hover:text-white ease-in-out px-10 py-2 hovereffect"
                  @click="$emit('ClickedOption', dropdown.title)"
                >
                  {{ dropdown.title }}
                </h3>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "LecturerConsultationSidebar",
  data() {
    return {
      // Your data goes here
      sidebarData: [
        {
          title: "Pending",
          iconpath: "src/assets/pending.png",
        },
        {
          title: "Reschedule Request",
          iconpath: "src/assets/request.png",
        },
        {
          title: "Approved",
          iconpath: "src/assets/approve.png",
        },
        {
          title: "Rescheduled",
          iconpath: "src/assets/clock.png",
        },

        {
          title: "History",
          iconpath: "src/assets/history.png",
          dropdown: [
            {
              title: "Rejected",
            },
            {
              title: "Expired",
            },
          ],
        },
      ],
    };
  },
};
</script>

<style scoped>
.hovereffect:hover {
  filter: drop-shadow(0px 4px 5px black);
  transition: filter 0.2s;
}
</style>
