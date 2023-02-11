const requestVerifyEmail = () =>
  import("../../../views/Auth/requestVerifyEmail.vue");

export default [
  {
    path: "/request-verify-email",
    component: requestVerifyEmail,
    name: "requestVerifyEmail",
  },
];
