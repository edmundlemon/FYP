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
            href="/adminDashboard"
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
            class="relative group flex items-center font-semibold whitespace-nowrap"
          >
            <router-link :to="link.path" class="hover:text-gray-400">{{
              link.name
            }}</router-link>
            <ul
              v-if="link.dropdown"
              class="font-normal p-2 z-50 fade-down-animation absolute left-0 top-full bg-gray-700 text-white rounded shadow-lg hidden group-hover:flex flex-col whitespace-nowrap"
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
                :src="'src/assets/admin.jpg'"
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
  </navbar>
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
</style>

<script>
export default {
  data() {
    return {
      navigation: [
        { name: 'Dashboard', path: '/adminDashboard' },
        { 
          name: 'Registration', path: '', dropdown: [
            { name: 'Register Students', path: '/registration/students', role: 'admin' },
            { name: 'Register Lecturers', path: '/registration/lecturers', role: 'admin' }
          ]
        },
        { 
          name: 'Edit Details', path: '', dropdown: [
            { name: 'Edit Students', path: '/edit-details/students', role: 'admin'},
            { name: 'Edit Lecturers', path: '/edit-details/lecturers', role: 'admin' },
          ]
        },
        { name: 'Lecturer Reviews', path: '/lecturer-listreviews' }
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
    // activeClass(index) {
    //   this.navigation.forEach((item, i) => {
    //     if (i === index) {
    //       item.current = true;
    //     } else {
    //       item.current = false;
    //     }
    //   });
    // }, no need this kut
  },
  mounted() {
    document.addEventListener("click", this.handleClickOutside);
  },
  beforeDestroy() {
    document.removeEventListener("click", this.handleClickOutside);
  },
  // mounted() {
  //   window.addEventListener('click', () => {
  //     if(this.showNotification !== false) {
  //       this.showNotifications = false;
  //     }
  //   });
  // },
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

const router = useRouter();
const token = store.state.user.token;

axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;


async function logout() {
  console.log("Logging out");
  store.commit("logout");
}
</script>
