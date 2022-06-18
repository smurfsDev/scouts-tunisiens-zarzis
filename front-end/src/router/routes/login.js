const login = ()=>import("../../views/Auth/login.vue");

export default [
    {
      path: "/login",
      component: login,
      name: "login"
    },
  ]; 