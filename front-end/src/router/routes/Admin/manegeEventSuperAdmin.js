const manageEventSuperAdmin = () => import("@/views/Admin/manageEventView.vue");

export default [
  {
    path: "/manageEventSuperAdmin",
    component: manageEventSuperAdmin,
    name: "manageEventSuperAdmin",
    meta: { requiresSuperAdmin: true },
  },
];
