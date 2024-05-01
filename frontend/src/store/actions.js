import axiosclient from "axios"

export function getUser({ commit }, data) {
	return axiosclient.get('/api/login', data).then(({data}) => {
		commit('setUser', data);
		return data;
	})
}

export function login({commit}, data){
	// return axiosclient.post('/api/login', data).then((response) => {
	// 	commit('setUser', response.data)
	// })
	console.log("This is from actions.js : ", data);
	commit('setUser', data.user);
	commit('setToken', data.token);
}
