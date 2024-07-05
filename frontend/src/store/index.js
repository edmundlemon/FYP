import { createStore } from "vuex";
import createPersistedState from 'vuex-persistedstate';
import * as mutations from "./mutations";
import * as actions from "./actions";

const store = createStore({
	state: {
		isAuthenticated: null,
		user:{},
		token: null,
		role: [],
		flashMessage: null,
	},
	getters:{
		getFlashMessage: state => state.flashMessage
	},
	mutations,
	actions,
	plugins: [createPersistedState()]
});


export default store;