import { createRouter, createWebHistory } from "vue-router";
import store from "../store";
import Login from "../views/Login.vue";
import Logout from "../components/Atom/Logout.vue";
import Dashboard from "../views/Dashboard.vue";
import NotFound from "../views/NotFound.vue";
import Lecturers from "../components/Organism/Lecturers.vue";
import RegisterLecturer from "../components/Organism/RegisterLecturer.vue";
import Students from "../components/Organism/Students.vue";
import LecturerDetails from "../components/Organism/LecturerDetailsPage.vue";
import LecturerProfile from "../components/Organism/LecturerDetailsPage.vue";
import StudentProfile from "../components/Organism/StudentDetailsPage.vue";
import Scheduling from "../components/Organism/Scheduling.vue";


import adminRoutes from "./adminRoutes";
import lecturerRoutes from "./lecturerRoutes";
import studentRoutes from "./studentRoutes";

const authRoutes = [
  {
    path: "/dashboard",
    name: "dashboard",
    component: Dashboard,
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: "/logout",
    name: "logout",
    component: Logout,
    meta: {
      requiresAuth: true,
    },
    beforeEnter: async (to, from, next) => {
      store.commit("logout");
      next("/login"); // Redirect to login page after logout
    },
  },
  {
    path: "/lecturer/:id",
    name: "LecturerDetails",
    component: LecturerDetails,
    props: true, // Allows passing route params as props to the component
    // meta: {
    // 	requireAuth: true
    // }
  },
];

const routes = [
  // Common and root directory routes.
  {
    path: "/",
    name: "root",
    // component: () => import('../App.vue'),
    redirect: (to) => {
      return store.state.isAuthenticated ? "/dashboard" : "/login";
    },
  },
  {
    path: "/login",
    name: "login",
    component: Login,
    meta: {
      requiresGuest: true,
    },
  },
  {
    path: "/lecturer/:id",
    name: "lecturer",
    component: LecturerProfile,
    props: true,
  },
  {
    path: "/student/:id",
    name: "student",
    component: StudentProfile,
    props: true,
  },
  {
    path: "/scheduling",
    name: "scheduling",
    component: Scheduling,
    props: true,
  },

  // The route that displays the 404 Error page.
  {
    path: "/:pathMatch(.*)*",
    name: "notfound",
    component: NotFound,
  },

  // Other routes, that are protected
  ...authRoutes,
  ...adminRoutes,
  ...lecturerRoutes,
  ...studentRoutes,
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const publicPages = ["/login"];
  const authRequired = !publicPages.includes(to.path);
  const loggedIn = store.state.isAuthenticated;

  const requiredRole = to.meta.role || [];
  const userRole = store.state.role || [];
  console.log(requiredRole);
  console.log(userRole);
  console.log(requiredRole.includes(userRole));
  if (to.meta.requiresAuth && !loggedIn) {
    return next("/login");
  } else if (to.meta.requiresGuest && loggedIn) {
    return next("/dashboard");
  }
  if (to.meta.role && !requiredRole.includes(userRole)) {
    return next("/dashboard");
  }

  next();
});

export default router;
