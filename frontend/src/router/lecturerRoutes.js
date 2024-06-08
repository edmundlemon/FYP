import Lecturers from '../components/Organism/Lecturers.vue';

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