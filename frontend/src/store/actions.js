import axios from "axios";
import router from "../router/routes";

export async function getUser({ commit }, data) {
  return axios.get("/api/login", data).then(({ data }) => {
    commit("setUser", data);
    return data;
  });
}

export function login({ commit }, data) {
  console.log("This is from actions.js : ", data);
  commit("setUser", data.user);
  commit("setToken", data.token);
  commit("setRole", data.role);
}

export function setFlashMessage({ commit }, message) {
  commit("SET_FLASH_MESSAGE", message);
}

export function clearFlashMessage({ commit }) {
  commit("CLEAR_FLASH_MESSAGE");
}
