import Lecturers from '../components/Lecturers.vue';

export default [
	{
		path: '/lecturers',
		name: 'lecturers',
		component: Lecturers,
		meta: { 
			requiresAuth: true,
		},
	},
];