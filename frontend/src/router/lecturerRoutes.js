import Lecturers from '../components/Organism/Lecturers.vue';
import FreeSlotForm from '../components/Molecules/FreeSlotForm.vue';
import FreeslotManager from '../components/Organism/Freeslot-manage.vue';
import ConsultationManager from '../components/Organism/Consultation-manage.vue';
export default [
	{
		path: '/lecturers',
		name: 'lecturers',
		component: Lecturers,
		meta: { 
			requiresAuth: true,
		},
	},
	{
		path: '/add-slot',
		name: 'addSlots',
		component: FreeSlotForm,
		meta:{
			requiresAuth: true,
			role: ['lecturer']
		}
	},
	{
		path: '/freeslot-manager',
		name: 'freeslot-manager',
		component: FreeslotManager,
	},
	{
		path: '/consultation-manager',
		name: 'consultation-manager',
		component: ConsultationManager,
	}

];