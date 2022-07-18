const manageTroops = () => import("@/views/Admin/manageTroops.vue");

export default [
  {
    path: "/manageTroops",
    component: manageTroops,
    name: "manageTroops",
    meta: {requiresSuperAdmin: true}
  },
];
