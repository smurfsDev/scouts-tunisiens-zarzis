const manageMembers = () => import("@/views/UnitLeader/manageMembers.vue");

export default [
  {
    path: "/manageMembers",
    component: manageMembers,
    name: "manageMembers",
    meta: { requiresUnitLeader: true },
  },
];
