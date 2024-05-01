import { createStore } from "vuex";
import * as mutations from "./mutations";
import * as actions from "./actions";

const store = createStore({
	state: {
		isAuthenticated: null,
		user:{},
		token: null,
	},
	getters:{},
	mutations,
	actions
});


export default store;