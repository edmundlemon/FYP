import RegisterLecturer from '../components/Organism/RegisterLecturer.vue';
import AdminHeader from '../components/Molecules/AdminHeader.vue';
import AdminDashboard from '../components/Organism/AdminDashboard.vue';
import AdminEDStudent from '../components/Molecules/AdminEDStudentForm.vue';
import AdminEDLecturer from '../components/Molecules/AdminEDLecturerForm.vue';
import AdminStudentED from '../components/Organism/AdminStudentED.vue';
import AdminLecturerED from '../components/Organism/AdminLecturerED.vue';
import AdminRegStudent from '../components/Organism/AdminRegStudent.vue';
import AdminRegLecturer from '../components/Organism/AdminRegLecturer.vue';
import AdminLecListReview from '../components/Organism/AdminLecListReview.vue';
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
	{
		path: "/adminHeader",
		name: "adminHeader",
		component: AdminHeader,
		props: true,
	},
	{
		path: "/adminDashboard",
		name: "adminDashboard",
		component: AdminDashboard,
		props: true,
		meta: {
			requiresAuth: true,
			role: ['admin']
		}
	},
	{
		path: "/adminEDStudent",
		name: "adminEDStudent",
		component: AdminEDStudent,
		props: true,
		meta: {
			requiresAuth: true,
			role: ['admin']
		}
	},
	{
		path: "/adminEDLecturer",
		name: "adminEDLecturer",
		component: AdminEDLecturer,
		props: true,
		meta: {
			requiresAuth: true,
			role: ['admin']
		}
	},
	{
		path: "/edit-details/students",
		name: "edit-details/students",
		component: AdminStudentED,
		props: true,
		meta: {
			requiresAuth: true,
			role: ['admin']
		}	
	},
	{
		path: "/edit-details/lecturers",
		name: "edit-details/lecturers",
		component: AdminLecturerED,
		props: true,
		meta: {
			requiresAuth: true,
			role: ['admin']
		}	
	},
	{
		path: "/registration/students",
		name: "registration/students",
		component: AdminRegStudent,
		props: true,
		meta: {
			requiresAuth: true,
			role: ['admin']
		}	
	},
	{
		path: "/registration/lecturers",
		name: "registration/lecturers",
		component: AdminRegLecturer,
		props: true,
		meta: {
			requiresAuth: true,
			role: ['admin']
		}	
	},
	{
		path: "/lecturer-listreviews",
		name: "lecturer-listreviews",
		component: AdminLecListReview,
		props: true,
		meta: {
			requiresAuth: true,
			role: ['admin']
		}	
	},
];