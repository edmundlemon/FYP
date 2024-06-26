import { createRouter, createWebHistory } from "vue-router";
import store from '../store';
import Login from '../views/Login.vue';
import Dashboard from '../views/Dashboard.vue';
import NotFound from '../views/NotFound.vue';
import Lecturers from '../components/Lecturers.vue';
import RegisterLecturer from '../components/RegisterLecturer.vue';

const routes = [
	{
		path: '/',
		name: 'app',
		component: () => import('../App.vue'),
		meta: { 
			requiresAuth: true 
		},
		children: [
			{
				path: '/dashboard',
				name: 'dashboard',
				component: Dashboard,
			},
		],
	},
	{
		path: '/login',
		name: 'login',
		component: Login,
		meta: { 
			requiresGuest: true 
		},
	},
	{
		path: '/:pathMatch(.*)*',
		name: 'notfound',
		component: NotFound,
	},
	{
		path: '/lecturers',
		name: 'lecturers',
		component: Lecturers,
	},
	{
		path: '/register-lecturer',
		name: 'register-lecturer',
		component: RegisterLecturer,
	},
];

const router = createRouter({
	history: createWebHistory(),
	routes
})

router.beforeEach((to, from, next) => {
	const publicPages = ['/login'];
	const authRequired = !publicPages.includes(to.path);
	const loggedIn = store.state.isAuthenticated;

	if (to.meta.requiresAuth && !loggedIn) {
		return next('/login');
	}
	else if (to.meta.requiresGuest && loggedIn) {
		return next('/dashboard');
	}


	next();
});

export default router;