const resetPassword = () =>
  import("@/views/Auth/resetPassword/resetPassword.vue");
export default [
  {
    path: "/reset-password",
    component: resetPassword,
    name: "resetPassword",
  },
];
