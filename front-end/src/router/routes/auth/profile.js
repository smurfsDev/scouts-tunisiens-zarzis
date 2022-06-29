const profile = () => import("../../../views/Auth/profile.vue");

export default [
  {
    path: "/profile",
    component: profile,
    name: "profile",
    meta: { requiresAuth: true },
  },
];
