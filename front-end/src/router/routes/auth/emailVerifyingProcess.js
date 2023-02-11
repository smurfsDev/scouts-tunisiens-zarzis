const verifyEmail = () =>
  import("../../../views/Auth/emailVerifyingProcess.vue");

export default [
  {
    path: "/verify-email",
    component: verifyEmail,
    name: "verifyEmail",
  },
];
