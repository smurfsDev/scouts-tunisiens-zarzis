const forgotPassword = () =>
  import("@/views/Auth/resetPassword/forgotPassword.vue");
export default [
  {
    path: "/forgot-password",
    component: forgotPassword,
    name: "forgotPassword",
  },
];
