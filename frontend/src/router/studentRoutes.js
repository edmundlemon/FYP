export default [
	{
		path: '/students',
		name: 'students',
		component: () => import('../components/Students.vue'),
		meta: {
			requiresAuth: true,
			role: ['student']
		}
	},
];