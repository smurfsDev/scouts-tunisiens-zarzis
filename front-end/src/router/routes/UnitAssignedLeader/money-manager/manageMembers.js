const manageMembersSubs = () =>
  import("@/views/UnitAssignedLeader/money-manager/manageMembers.vue");

export default [
  {
    path: "/manageMembersSubs",
    component: manageMembersSubs,
    name: "manageMembersSubs",
    meta: { requiresMoneyManager: true },
  },
];
