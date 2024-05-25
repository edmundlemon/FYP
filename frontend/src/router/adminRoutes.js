import RegisterLecturer from '../components/RegisterLecturer.vue';
// import Students from '../views/Students.vue';

export default [
	// {
	// 	path: '/students',
	// 	name: 'students',
	// 	component: Students,
	// 	meta: {
	// 		requiresAuth: true,
	// 		role: ['admin']
	// 	}
	// },
	{
		path: '/register-lecturer',
		name: 'register-lecturer',
		component: RegisterLecturer,
		meta: {
			requiresAuth: true,
			role: ['admin']
		}
	},
];