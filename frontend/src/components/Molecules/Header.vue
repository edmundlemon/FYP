<template>
  <navbar class="nav-wrapper margin-0">
    <div
      class="navbar-container bg-gray-800 h-28 flex items-center justify-between px-4 sm:px-6 lg:px-8"
      style="filter: drop-shadow(0px 3px 3px black)"
    >
      <div class="ml-10 left-navbar flex flex-row">
        <div class="">
          <!-- add some margin to the right of the logo -->
          <a
            href="/dashboard"
            class="text-white text-lg font-bold flex flex-row justify-center items-center"
          >
            <img class="h-12" src="../../assets/logo.png" alt="" />
            3LINGGUN
          </a>
        </div>

        <ul class="flex space-x-8 text-white ml-12">
          <li
            v-for="(link, index) in navigation"
            :key="index"
            class="relative group flex items-center font-semibold"
          >
            <router-link :to="link.path" class="hover:text-gray-400">{{
              link.name
            }}</router-link>
            <ul
              v-if="link.dropdown"
              class="font-normal p-2 fade-down-animation absolute left-0 top-full bg-gray-700 text-white rounded shadow-lg hidden group-hover:flex flex-col whitespace-nowrap"
            >
              <li
                class="relative"
                v-for="(sublink, subIndex) in link.dropdown"
                :key="subIndex"
              >
                <router-link
                  v-if="sublink.role === store.state.role"
                  :to="sublink.path"
                  class="block px-4 py-2 rounded-r-lg transition-all duration-300 ease-in-out"
                  >{{ sublink.name }}</router-link
                >
                <router-link
                  v-else-if="sublink.role === 'all'"
                  :to="sublink.path"
                  class="block px-4 py-2 rounded-r-lg transition-all duration-300 ease-in-out"
                  >{{ sublink.name }}</router-link
                >
              </li>
            </ul>
          </li>
        </ul>
        <SearchBar class="ml-5 z-50 w-[25vw]" v-if="store.state.token" />
      </div>

      <!-- notification & profile drop down menu -->
      <div
        class="mr-5 absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0 gap-4"
      >
        <button
          title="Notification"
          ref="dropdownContainer"
          type="button"
          class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
          @click="toggleDropdown"
        >
          <span class="absolute -inset-1.5" />
          <span class="sr-only">View notifications</span>

          <div
            class="animate-bounce border text-xs absolute top-[-10%] right-[-18%] bg-red-900 rounded-full w-4 h-4 flex justify-center items-center right-0"
            v-if="rescheduleSlots + rejectedSlots + cancelledSlots > 0"
          >
            <p class="text-center">
              {{ rescheduleSlots + rejectedSlots + cancelledSlots }}
            </p>
          </div>
          <BellIcon class="h-6 w-6" aria-hidden="true" />
          <transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
          >
            <ul
              v-if="isDropdownOpen"
              class="bg-gray-100 space-y-1 absolute right-0 mt-6 origin-top-right rounded-md pt-5 px-2 pb-2 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
              style="width: 40vh; z-index: 9999"
            >
              <div class="flex flex-row space-x-2 items-center pb-3">
                <img
                  class="w-5 h-5"
                  src="../../assets/notification.png"
                  alt=""
                />
                <h4 class="text-2xl text-left text-gray-700">Requests</h4>
              </div>
              <!-- <li class="block px-4 py-2 text-sm text-gray-700">
                Notification will show here!
              </li> -->

              <!-- Reschedule slots Notification is here -->
              <li
                v-if="rescheduleSlots > 0"
                :key="index"
                class="block px-4 py-2 text-sm text-gray-700 bg-white rounded"
                @click="router.push('/consultation-manager')"
                style="z-index: 9999"
              >
                <p>
                  You have {{ rescheduleSlots }} reschedule
                  {{ rescheduleSlots == 1 ? "request" : "requests" }}
                  pending for approval in the
                  <span class="text-blue-500">request section</span>.
                </p>
              </li>

              <!-- Cancelled slots Notification is here -->
              <li
                v-if="cancelledSlots > 0"
                :key="index"
                class="block px-4 py-2 text-sm text-gray-700 bg-white rounded"
                @click="router.push('/consultation-manager')"
                style="z-index: 9999"
              >
                <p v-if="store.state.role === 'lecturer'">
                  You have {{ cancelledSlots }}
                  {{ cancelledSlots == 1 ? "student" : "students" }}
                  cancelled their consultation with you, please approve their
                  cancellation request in the
                  <span class="text-blue-500">request section</span>.
                </p>
                <p v-else>
                  You have {{ cancelledSlots }}
                  {{ cancelledSlots == 1 ? "consultation" : "consultations" }}
                  cancelled by the lecturer, you can check in the
                  <span class="text-blue-500">cancelled section</span>.
                </p>
              </li>

              <!-- Rejected slots notification is here -->
              <li
                v-if="rejectedSlots > 0"
                :key="index"
                class="block px-4 py-2 text-sm text-gray-700 bg-white rounded"
                @click="router.push('/consultation-manager')"
                style="z-index: 9999"
              >
                <p>
                  You have {{ rejectedSlots }}
                  {{ rejectedSlots == 1 ? "consultation" : "consultations" }}
                  rejected by the
                  {{
                    store.state.role === "lecturer" ? "student" : "lecturer"
                  }}, you can check in the
                  <span class="text-blue-500">rejected section</span>.
                </p>
              </li>
              <li
                v-if="
                  rescheduleSlots === 0 &&
                  cancelledSlots === 0 &&
                  rejectedSlots === 0
                "
                class="block px-4 py-2 text-sm text-gray-700"
              >
                No new requests yet...
              </li>
            </ul>
          </transition>
        </button>

        <!-- Profile dropdown -->
        <Menu as="div" class="relative ml-3">
          <div>
            <MenuButton
              class="relative flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
            >
              <span class="absolute -inset-1.5" />
              <span class="sr-only">Open user menu</span>
              <img
                class="h-8 w-8 rounded-full"
                :src="store.state.user.data.photo"
                alt=""
              />
              <!-- PROFILE IN NAV BAR PICTURER HERE -->
            </MenuButton>
          </div>
          <transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
          >
            <MenuItems
              class="absolute right-0 z-10 mt-5 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
            >
              <MenuItem v-slot="{ active }">
                <a
                  :href="
                    store.state.role === 'lecturer'
                      ? '/lecturer/' + store.state.user.data.id
                      : '/student/' + store.state.user.data.id
                  "
                  :class="[
                    active ? 'bg-gray-100' : '',
                    'block px-4 py-2 text-sm text-gray-700',
                  ]"
                  >Your Profile</a
                >
              </MenuItem>
              <MenuItem v-slot="{ active }">
                <a
                @click="changePfp = true"
                  href="#"
                  :class="[
                    active ? 'bg-gray-100' : '',
                    'block px-4 py-2 text-sm text-gray-700',
                  ]"
                  >Change Profile Picture</a>
              </MenuItem>
              <MenuItem v-slot="{ active }">
                <a
                  @click="logout"
                  href="#"
                  :class="[
                    active ? 'bg-gray-100' : '',
                    'block px-4 py-2 text-sm text-gray-700',
                  ]"
                  >Sign out</a
                >
              </MenuItem>
            </MenuItems>
          </transition>
        </Menu>
      </div>
    </div>
    <div v-if="changePfp" class="booking-container fixed top-0 left-0 w-full h-full bg-white bg-opacity-50 z-50 flex justify-center items-center">
      <ChangeProfilePic v-if="changePfp"  
      class="border border-gray-600 rounded-xl border-2 fadein-animation"
      style="filter: drop-shadow(0px 4px 10px black)" @close="changePfp = false" />
    </div>
  </navbar>
  <!-- {{ store.state.role }}
  {{ rejectedSlots }}
  {{ rescheduleSlots }}
  {{ cancelledSlots }} -->
</template>

<style scoped>
.left-navbar ul li a {
  position: relative;
  padding-bottom: 5px;
}

.left-navbar ul li a::before {
  content: "";
  position: absolute;
  width: 0;
  height: 2px;
  bottom: 0;
  left: 0;
  background-color: #ffffff;
  visibility: hidden;
  transition: all 0.3s ease-in-out;
}

.left-navbar ul li a:hover::before {
  visibility: visible;
  width: 100%;
}

.left-navbar ul ul li a {
  position: relative;
  padding-left: 5px; /* add some padding to make room for the indent */
  transition: padding 0.3s ease-in-out, transform 0.3s ease-in-out;
  padding-bottom: 5px;
}

.left-navbar ul ul li a::before {
  content: "";
  position: absolute;
  width: 0;
  height: 2px;
  bottom: 0;
  left: 0;
  background-color: #59ffe1;
  visibility: hidden;
  transition: all 0.3s ease-in-out;
}

.left-navbar ul ul li a:hover {
  padding-left: 15px; /* add an indent on hover */
}

.left-navbar ul ul li a:hover::before {
  visibility: visible;
  transform: scaleX(1);
}

navbar {
  position: relative;
  top: 0;
  left: 0;
  right: 0;
  z-index: 9999;
}
</style>

<script>
export default {
  data() {
    return {
      navigation: [
        { name: "Dashboard", path: "/dashboard" },
        {
          name: "Lecturers",
          path: "/lecturers",
        },
        {
          name: "Students",
          path: "/students",
        },
        {
          name: "Scheduling",
          path: "/scheduling",
          dropdown: [
            {
              role: "lecturer",
              name: "Manage Free Slots",
              path: "/freeslot-manager",
            },
            {
              role: "all",
              name: "Manage Consultations",
              path: "/consultation-manager",
            },
          ],
        },
        {
          name: "Reviews",
          path: "/reviews",
        },
      ],
      showNotifications: false,
      isDropdownOpen: false,
    };
  },
  methods: {
    toggleDropdown() {
      this.isDropdownOpen = !this.isDropdownOpen;
    },
    handleClickOutside(event) {
      const dropdownContainer = this.$refs.dropdownContainer;
      if (dropdownContainer && !dropdownContainer.contains(event.target)) {
        this.isDropdownOpen = false;
      }
    },
  },
  mounted() {
    document.addEventListener("click", this.handleClickOutside);
  },
  beforeDestroy() {
    document.removeEventListener("click", this.handleClickOutside);
  },
};
</script>
<script setup>
import {
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
} from "@headlessui/vue";
import { Bars3Icon, BellIcon, XMarkIcon } from "@heroicons/vue/24/outline";
import store from "../../store";
import axios from "axios";
import { useRouter } from "vue-router";
import { data } from "autoprefixer";
import SearchBar from "../Atom/SearchBar.vue";
import { ref, onMounted, onUnmounted, computed } from "vue";
import axiosInstance from "../../axiosConfig/customAxios";
import ChangeProfilePic from "./ChangeProfilePic.vue";

const rescheduleSlots = ref(0);
const cancelledSlots = ref(0);
const rejectedSlots = ref(0);
const changePfp = ref(false);
let intervalId = null;
onMounted(() => {
  console.log("mounted");
  getNotification();
  intervalId = setInterval(getNotification, 10000); // Set up the interval
});

onUnmounted(() => {
  console.log("unmounted");
  clearInterval(intervalId); // Clear the interval
});

function getNotification() {
  console.log("Getting notification");
  axiosInstance
    .get("/user/notification")
    .then((response) => {
      rescheduleSlots.value = response.data.rescheduled_slots;
      cancelledSlots.value = response.data.cancelled_slots;
      rejectedSlots.value = response.data.rejected_slots;
    })
    .catch((error) => {
      console.log(error);
    });
}

const router = useRouter();
const token = store.state.user.token;

axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

//   const navigation = [
// 	{ name: 'Dashboard', href: '/dashboard', current: true },
// 	{ name: 'Team', href: '#', current: false },
// 	{ name: 'Projects', href: '#', current: false },
// 	{ name: 'Calendar', href: '#', current: false },
//   ]

async function logout() {
  clearInterval(intervalId); // Clear the interval
  console.log("Logging out");
  store.commit("logout");
}
</script>
