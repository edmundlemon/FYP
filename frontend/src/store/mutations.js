import axios from "axios";
import router from "../router/routes";

export function setUser(state, user) {
  state.user.data = user;
  state.isAuthenticated = true;
}

export function setToken(state, token) {
  state.token = token;
  console.log("Token is : ", state.token);
}

export function setRole(state, role) {
  state.role = role;
}

export function logout(state) {
  console.log(state.token);
  axios.defaults.headers.common["Authorization"] = `Bearer ${state.token}`;
  axios
    .post("http://localhost:8000/api/logout")
    .then((response) => {
      console.log("Logout response: ", response);
    })
    .catch((error) => {
      console.log("Logout error: ", error);
      router.push("/login");
      // return Promise.reject(error);
    });
  state.user.data = {};
  state.isAuthenticated = false;
  state.token = null;
  console.log("Token is : ", state.token);
  router.push("/login");
}

export function setPhoto(state, photo) {
  state.user.data.photo = photo;
}

export function SET_FLASH_MESSAGE(state, message) {
  state.flashMessage = message;
}

export function CLEAR_FLASH_MESSAGE(state) {
  state.flashMessage = null;
}
