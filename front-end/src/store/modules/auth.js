import router from "../../router";
import axios from "axios";
const state = {
  csrfToken: null,
  isLoggedIn:
    localStorage.getItem("user") !== null &&
    localStorage.getItem("token") !== null,
  authUser: JSON.parse(localStorage.getItem("user")) ?? null,
  token: localStorage.getItem("token") ?? null,
  regStatus: null,
  regMessage: null,
  authStatus: null,
  authMessage: null,
};
const getters = {
  isLoggedIn: (state) => state.isLoggedIn,
  authUser: (state) => state.authUser,
  token: (state) => state.token,
  regStatus: (state) => state.regStatus,
  regMessage: (state) => state.regMessage,
  authStatus: (state) => state.authStatus,
  authMessage: (state) => state.authMessage,
};
const mutations = {
  setLoggedIn(state, payload) {
    state.isLoggedIn = payload;
  },
  setAuthUser(state, payload) {
    state.authUser = payload;
  },
  setToken(state, payload) {
    state.token = payload;
  },
  setRegStatus(state, payload) {
    state.regStatus = payload;
  },
  setRegMessage(state, payload) {
    state.regMessage = payload;
  },
  setAuthMessage(state, payload) {
    state.authMessage = payload;
  },
  setAuthStatus(state, payload) {
    state.authStatus = payload;
  },
};
const actions = {
  async login({ commit }, payload) {
    axios
      .get("http://localhost:8000/sanctum/csrf-cookie", {
        withCredentials: true,
      })
      .then(() => {})
      .catch(() => {});
    await axios
      .post("/login", payload)
      .then((response) => {
        commit("setLoggedIn", true);
        commit("setAuthUser", response.data.user);
        localStorage.setItem("user", JSON.stringify(response.data.user));
        localStorage.setItem("token", response.data.token);
        commit("setToken", response.data.token);
        commit("setAuthStatus", 1);
        router.push("/");
      })
      .catch((error) => {
        commit("setAuthStatus", 2);
        commit("setAuthMessage", error.response.data.message); // this is the main part. Use the response property from the error object
      });
  },
  logout({ commit }) {
    return new Promise((resolve) => {
      router.push("/");
      commit("setLoggedIn", false);
      commit("setAuthUser", null);
      commit("setToken", null);
      localStorage.removeItem("user");
      localStorage.removeItem("token");
      resolve();
    });
  },
  async register({ commit }, User) {
    await axios
      .post("/register", User, {
        headers: {
          "Content-Type": "application/json",
        },
        withCredentials: true,
      })
      .then((response) => {
        if (response.status == 200) {
          router.push({ name: "login", params: { msg: "Vous êtes bien inscrit, vous pouvez vous connecter" ,variant:"success"} });
          commit("setRegStatus", 1);
        } else {
          console.log("jawna behi nai");
        }
      })
      .catch((error) => {
        commit("setRegStatus", 2);
        commit("setRegMessage", error.response.data.data); // this is the main part. Use the response property from the error object
      });
  },
};

export default {
  state,
  getters,
  actions,
  mutations,
};
