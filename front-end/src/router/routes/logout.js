const logout = ()=>import("../../views/Auth/logout.vue");

export default [
    {
      path: "/logout",
      component: logout,
      name: "logout"
    },
  ]; 