<template>
  <div
    class="bg-style relative bg-gray-50 flex flex-col items-center justify-center border border-gray-300 p-5 w-full rounded-lg shadow-md pt-6 hover:shadow-2xl hover:scale-105 transition duration-300 ease-in-out"
  >
    <div
      class="absolute left-3 rounded-t-lg blur-bottom"
      style="top: -3%; background-color: #f15a59; z-index: 5000"
    >
      <p class="text-lg px-6 font-semibold text-center">
        {{ user.faculty }}
      </p>
    </div>
    <!-- Lecturer Image -->
    <a
      class="mb-8 mt-3"
      :href="
        role === 'lecturer' ? '/lecturer/' + user.id : '/student/' + user.id
      "
    >
      <img
        :src="user.photo"
        alt="Descriptive Alt Text"
        class="picture h-32 object-contain rounded-full"
      />
    </a>

    <!-- Lecturer name block -->
    <div
      class="space-y-3 flex flex-col items-center justify-center w-full mt-0 z-10"
    >
      <!-- Name @ box with lecturer name-->
      <div
        class="w-full transition-all duration-300 ease-in-out transform hover:scale-105 relative z-10 p-0"
      >
        <div
          class="font-semibold absolute bg-green-400 opacity-70 rounded-xl px-2 text-xl border border-gray-700 border-opacity-50"
          style="z-index: 10; top: -35%; left: 0%"
        >
          <span class="font-light text-xs whitespace-nowrap tracking-wide p-0">
            NAME
          </span>
        </div>

        <a
          :href="
            role === 'lecturer' ? '/lecturer/' + user.id : '/student/' + user.id
          "
        >
          <h1
            class="name-box bg-gray-200 rounded-xl py-2 px-5 text-2xl font-bold border border-black text-center"
          >
            {{ user.name }}
          </h1>
        </a>
      </div>
      <!-- Lecturer Email Display -->
      <div
        class="flex flex-row justify items-center transition duration-300 ease-in-out transform hover:scale-105 z-10 detail-box px-3 rounded-xl w-full"
      >
        <img
          src="../../assets/email.png"
          alt="email_icon"
          class="w-5 h-5 mr-2"
          title="Email Address"
        />

        <p class="text-lg my-1.5 h-full truncate flex items-center">
          <a class="font-normal w-full block" :href="'mailto:' + user.email"
            >{{ user.email }}
          </a>
        </p>
      </div>

      <!-- Student Program / Lecturer office -->
      <div
        class="flex flex-row justify items-center z-10 w-full transition duration-300 ease-in-out transform hover:scale-105"
      >
        <div class="flex flex-row w-full space-x-[0.2px]">
          <div
            class="text-lg z-10 detail-box text-center rounded-l-xl p-2 px-3 flex items-center justify-center"
          >
            <img
              :src="
                role === 'lecturer'
                  ? 'src/assets/office.png'
                  : 'src/assets/faculty.png'
              "
              alt="office_icon"
              class="w-5 h-5"
              :title="role === 'lecturer' ? 'Office' : 'Program'"
            />
          </div>

          <div class="w-full">
            <p
              class="text-lg z-10 detail-box rounded-r-xl py-2 pl-3 truncate"
              v-if="role === 'lecturer'"
            >
              {{ user.office }}
            </p>
            <p class="text-lg z-10 detail-box rounded-r-xl py-2 pl-3 truncate" v-else>
              {{ user.program }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, onMounted } from "vue";

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
  role: {
    type: String,
  },
});
</script>

<style scoped>
.blur-bottom::after {
  content: "";
  position: absolute;
  bottom: -2px; /* Adjust as needed */
  left: 0;
  right: 0;
  height: 5px; /* Adjust as needed */
  background: inherit;
  filter: blur(4px); /* Adjust blur radius as needed */
  z-index: -1; /* To place the blur behind the original div content */
  border-bottom-left-radius: inherit; /* To match the border radius */
  border-bottom-right-radius: inherit; /* To match the border radius */
}

.name-box {
  /* From https://css.glass */
  background: rgba(146, 255, 67, 0.1);
  box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
  backdrop-filter: blur(6.6px);
  -webkit-backdrop-filter: blur(6.6px);
  border: 1px solid rgba(146, 255, 67, 0.27);
}

.name-box:hover {
  background: rgba(146, 255, 67, 0.2);
  box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
  backdrop-filter: blur(6.6px);
  -webkit-backdrop-filter: blur(6.6px);
  border: 1px solid rgba(146, 255, 67, 0.27);
  transition: all 0.3s ease-in-out;
}

.detail-box {
  /* From https://css.glass */
  background: rgba(217, 217, 217, 0.2);
  box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
  backdrop-filter: blur(6.6px);
  -webkit-backdrop-filter: blur(6.6px);
  border: 1px solid rgba(88, 88, 88, 0.27);
}

.picture {
  filter: drop-shadow(0 0 0.75rem rgba(0, 0, 0, 0.4));
}
</style>
