export function setUser(state, user){
	state.user.data = user;
	state.isAuthenticated = true;
}

export function setToken(state, token){
	state.token = token;
	console.log("Token is : ", state.token);
}

export function logout(state){
	state.user.data = {};
	state.isAuthenticated = false;
	state.token = '';
}
