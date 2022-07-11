const officialRequest = () => import("@/views/officialRequest/officialRequest.vue");

export default [
  {
    path: "/officialRequest",
    component: officialRequest,
    name: "officialRequest",
    meta: {requiresSuperAdmin: true}
  },
];
