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
	{
		path: '/student/schedule',
		name: 'student-schedule',
		component: () => import('../components/UpcomingSlot.vue'),
		// meta: {
		// 	requiresAuth: true,
		// 	role: ['student']
		// }
	}
];