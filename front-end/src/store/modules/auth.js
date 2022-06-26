import router from "../../router";
import axios from "axios";
const state = {
  csrfToken: null,
  isLoggedIn:
    localStorage.getItem("user") !== null &&
    localStorage.getItem("token") !== null,
  authUser: JSON.parse(localStorage.getItem("user")) ?? null,
  token: localStorage.getItem("token") ?? null,
  isSuperAdmin: localStorage.getItem("isSuperAdmin")??null,
  isLeadership: localStorage.getItem("isLeadership")??null,
  isUnitLeader: localStorage.getItem("isUnitLeader")??null,
  isUnitSubLeader: localStorage.getItem("isUnitSubLeader")??null,
  isUnitAssignedLeader : localStorage.getItem("isUnitAssignedLeader")??null,
  isParent: localStorage.getItem("isParent")??null,
  isMember: localStorage.getItem("isMember")??null,
  regStatus: null,
  regMessage: null,
  authStatus: null,
  authMessage: null,
  status: localStorage.getItem("status") ?? null,
};
const getters = {
  isLoggedIn: (state) => state.isLoggedIn,
  authUser: (state) => state.authUser,
  token: (state) => state.token,
  regStatus: (state) => state.regStatus,
  regMessage: (state) => state.regMessage,
  authStatus: (state) => state.authStatus,
  authMessage: (state) => state.authMessage,
  isSuperAdmin: (state) => state.isSuperAdmin,
  isLeadership: (state) => state.isLeadership,
  isUnitLeader: (state) => state.isUnitLeader,
  isUnitSubLeader: (state) => state.isUnitSubLeader,
  isUnitAssignedLeader: (state) => state.isUnitAssignedLeader,
  isParent: (state) => state.isParent,
  isMember: (state) => state.isMember,
  status: (state) => state.status
};
const mutations = {
  setLoggedIn(state, payload) {
    state.isLoggedIn = payload;
  },
  setAuthUser(state, payload) {
    state.authUser = payload;
    localStorage.setItem("user", JSON.stringify(payload));
  },
  setToken(state, payload) {
    state.token = payload;
    localStorage.setItem("token", payload);
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
  setIsSuperAdmin(state, payload) {
    state.isSuperAdmin = payload;
    localStorage.setItem("isSuperAdmin", payload);
  },
  setIsLeadership(state, payload) {
    state.isLeadership = payload;
    localStorage.setItem("isLeadership", payload);
  },
  setIsUnitLeader(state, payload) {
    state.isUnitLeader = payload;
    localStorage.setItem("isUnitLeader", payload);
  },
  setIsUnitSubLeader(state, payload) {
    state.isUnitSubLeader = payload;
    localStorage.setItem("isUnitSubLeader", payload);
  },
  setIsUnitAssignedLeader(state, payload) {
    state.isUnitAssignedLeader = payload;
    localStorage.setItem("isUnitAssignedLeader", payload);
  },
  setIsParent(state, payload) {
    state.isParent = payload;
    localStorage.setItem("isParent", payload);
  },
  setIsMember(state, payload) {
    state.isMember = payload;
    localStorage.setItem("isMember", payload);
  },
  setStatus(state, payload) {
    state.status = payload;
    localStorage.setItem("status", payload);
  },
  logout(state) {
    state.isLoggedIn = false;
    state.authUser = null;
    state.token = null;
    state.isSuperAdmin = false;
    state.isLeadership = false;
    state.isUnitLeader = false;
    state.isUnitSubLeader = false;
    state.isUnitAssignedLeader = false;
    state.isParent = false;
    state.isMember = false;
    state.status = null;
    localStorage.removeItem("user");
    localStorage.removeItem("token");
    localStorage.removeItem("isSuperAdmin");
    localStorage.removeItem("isLeadership");
    localStorage.removeItem("isUnitLeader");
    localStorage.removeItem("isUnitSubLeader");
    localStorage.removeItem("isUnitAssignedLeader");
    localStorage.removeItem("isParent");
    localStorage.removeItem("isMember");
    localStorage.removeItem("status");
  }
};
const actions = {
  async login({ commit }, payload) {
    axios
      .get("http://localhost:8000/sanctum/csrf-cookie", {
        withCredentials: true
      })
      .then(() => {})
      .catch(() => {});
    await axios
      .post("/login", payload)
      .then((response) => {
        commit("setLoggedIn", true);
        commit("setAuthUser", response.data.user);
        commit("setToken", response.data.token);
        commit("setStatus", response.data.status);
        commit("setAuthStatus", 1);
        let roles = response.data.roles;
        if (roles.includes("superAdmin")) {
          commit("setIsSuperAdmin", true);
        }
        if (roles.includes("leadership")) {
          commit("setIsLeadership", true);
        }
        if (roles.includes("unitLeader")) {
          commit("setIsUnitLeader", true);
        }
        if (roles.includes("unitSubLeader")) {
          commit("setIsUnitSubLeader", true);
        }
        if (roles.includes("unitAssignedLeader")) {
          commit("setIsUnitAssignedLeader", true);
        }
        if (roles.includes("parent")) {
          commit("setIsParent", true);
        }
        if (roles.includes("member")) {
          commit("setIsMember", true);
        }
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
      commit('logout');
      resolve();
    });
  },
  async register({ commit }, User) {
    await axios
      .post("/register", User, {
        headers: {
          "Content-Type": "application/json"
        },
        withCredentials: true
      })
      .then((response) => {
        if (response.status == 200) {
          router.push({
            name: "login",
            params: { msg: "لقد تم انشاء الحساب بنجاح", variant: "success" }
          });
          commit("setRegStatus", 1);
        } else {
          console.log("jawna behi nai");
        }
      })
      .catch((error) => {
        commit("setRegStatus", 2);
        commit("setRegMessage", error.response.data.data); // this is the main part. Use the response property from the error object
      });
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};
