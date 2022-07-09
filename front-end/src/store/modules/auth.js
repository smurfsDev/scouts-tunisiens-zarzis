import router from "../../router";
import axios from "axios";
const state = {
  csrfToken: null,
  isLoggedIn:
    localStorage.getItem("user") !== null &&
    localStorage.getItem("token") !== null,
  authUser: JSON.parse(localStorage.getItem("user")) ?? null,
  token: localStorage.getItem("token") ?? null,
  roles: JSON.parse(localStorage.getItem("roles")) ?? null,
  regStatus: null,
  regMessage: null,
  authStatus: null,
  authMessage: null,
  status: JSON.parse(localStorage.getItem("status")) ?? null,
  responsability: localStorage.getItem("responsability") ?? null
};
const getters = {
  isLoggedIn: (state) => state.isLoggedIn,
  authUser: (state) => state.authUser,
  token: (state) => state.token,
  regStatus: (state) => state.regStatus,
  regMessage: (state) => state.regMessage,
  authStatus: (state) => state.authStatus,
  authMessage: (state) => state.authMessage,
  isSuperAdmin: (state) => {
    let isSuperAdmin = null;
    state.roles?.forEach((role) => {
      if (role.role === "Super Admin" && role.status == 1) {
        isSuperAdmin = true;
      }
    });
    return isSuperAdmin;
  },
  isLeadership: (state) => {
    let isLeadership = null;
    state.roles?.forEach((role) => {
      if (role.role === "Leadership" && role.status == 1) {
        isLeadership = true;
      }
    });
    return isLeadership;
  },
  isUnitLeader: (state) => {
    let isUnitLeader = null;
    state.roles?.forEach((role) => {
      if (role.role === "Unit Leader" && role.status == 1) {
        isUnitLeader = true;
      }
    });
    return isUnitLeader;
  },
  isUnitSubLeader: (state) => {
    let isUnitSubLeader = null;
    state.roles?.forEach((role) => {
      if (role.role === "Unit Sub Leader" && role.status == 1) {
        isUnitSubLeader = true;
      }
    });
    return isUnitSubLeader;
  },
  isUnitAssignedLeader: (state) => {
    let isUnitAssignedLeader = null;
    state.roles?.forEach((role) => {
      if (role.role === "Unit Assigned Leader" && role.status == 1) {
        isUnitAssignedLeader = true;
      }
    });
    return isUnitAssignedLeader;
  },
  isParent: (state) => {
    let isParent = null;
    state.roles?.forEach((role) => {
      if (role.role === "Parent" && role.status == 1) {
        isParent = true;
      }
    });
    return isParent;
  },
  isMember: (state) => {
    let isMember = null;
    state.roles?.forEach((role) => {
      if (role.role === "Member" && role.status == 1) {
        isMember = true;
      }
    });
    return isMember;
  },
  isLeader: (state) => {
    let isLeader = null;
    state.roles?.forEach((role) => {
      if (role.role.includes("Leader") && role.status == 1) {
        isLeader = true;
      }
    });
    return isLeader;
  }
  ,
  status: (state) => state.status,
  responsability: (state) => state.responsability
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
  setRoles(state, payload) {
    state.roles = payload;
    localStorage.setItem("roles", JSON.stringify(payload));
  },
  setStatus(state, payload) {
    state.status = payload;
    localStorage.setItem("status", payload);
  },
  setResponsability(state, payload) {
    state.responsability = payload;
    localStorage.setItem("responsability", payload);
  },
  logout(state) {
    state.isLoggedIn = false;
    state.authUser = null;
    state.token = null;
    state.roles = null;
    state.status = null;
    state.responsability = null;
    localStorage.removeItem("user");
    localStorage.removeItem("token");
    localStorage.removeItem("roles");
    localStorage.removeItem("status");
    localStorage.removeItem("responsability");
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
        commit("setRoles", response.data.roles);
        commit("setResponsability", response.data.responsability);
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
      commit("logout");
      resolve();
    });
  },
  sessionExpired({ commit }) {
    commit("logout");
    router.push({
      name: "login",
      params: {
        msg: "انتهت صلاحية جلسة العمل الخاصة بك, الرجاء اعادة تسجيل الدخول",
        variant: "danger"
      }
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
