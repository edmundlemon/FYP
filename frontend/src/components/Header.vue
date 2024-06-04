<template>
  <navbar class="nav-wrapper">
    <div
      class="navbar-container bg-gray-800 h-28 flex items-center justify-between px-4 sm:px-6 lg:px-8"
      style="filter: drop-shadow(0px 3px 3px black)"
    >
      <div class="ml-10 left-navbar flex flex-row">
        <a
          href="#"
          class="text-white text-lg font-bold flex flex-row justify-center items-center"
        >
          <img class="h-12" src="../assets/logo.png" alt="" />
          3LINGGUN
        </a>

        <ul class="flex flex-row justify-center items-center ml-10 pr-5 gap-5">
          <li
            v-for="(item, index) in navigation"
            :key="index"
            @click="activeClass(index)"
          >
            <a
              :href="item.href"
              :class="[
                item.current
                  ? 'text-white font-bold'
                  : 'text-gray-300 hover:text-white',
                'ml-4 text-lg',
              ]"
              >{{ item.name }}</a
            >
          </li>
        </ul>
        <SearchBar v-if="store.state.token" />
      </div>
      <!-- notification & profile drop down menu -->
      <div
        class="mr-5 absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0 gap-4"
      >
        <button
          ref="dropdownContainer"
          type="button"
          class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
          @click="toggleDropdown"
        >
          <span class="absolute -inset-1.5" />
          <span class="sr-only">View notifications</span>

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
              class="absolute right-0 z-10 mt-6 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
              style="width: 40vh"
            >
              <li class="block px-4 py-2 text-sm text-gray-700">
                Notification will show here!
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
                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                alt=""
              />
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
                  href="#"
                  :class="[
                    active ? 'bg-gray-100' : '',
                    'block px-4 py-2 text-sm text-gray-700',
                  ]"
                  >Your Profile</a
                >
              </MenuItem>
              <MenuItem v-slot="{ active }">
                <a
                  href="#"
                  :class="[
                    active ? 'bg-gray-100' : '',
                    'block px-4 py-2 text-sm text-gray-700',
                  ]"
                  >Settings</a
                >
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
  </navbar>
</template>
<script>
export default {
  data() {
    return {
      navigation: [
        { name: "Dashboard", href: "/dashboard", current: false },
        { name: "Lecturers", href: "#", current: false },
        { name: "Students", href: "#", current: false },
        { name: "Scheduling", href: "#", current: false },
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
    activeClass(index) {
      this.navigation.forEach((item, i) => {
        if (i === index) {
          item.current = true;
        } else {
          item.current = false;
        }
      });
    },
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
import store from "../store/";
import axios from "axios";
import { useRouter } from "vue-router";
import { data } from "autoprefixer";
import SearchBar from "../components/SearchBar.vue";

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
  console.log("Logging out");
  store.commit("logout");
}
</script>
