export default [
	{
		path: '/students',
		name: 'students',
		component: () => import('../components/Organism/Students.vue'),
		meta: {
			requiresAuth: true,
		}
	},
	{
		path: '/student/schedule',
		name: 'student-schedule',
		component: () => import('../components/Molecules/UpcomingSlot.vue'),
		// meta: {
		// 	requiresAuth: true,
		// 	role: ['student']
		// }
	},
	{
		path: '/review',
		name: 'review',
		component: () => import('../components/Molecules/ReviewForm.vue'),
		meta:{
			requiresAuth: true,
			role: ['student']
		}
	}
];