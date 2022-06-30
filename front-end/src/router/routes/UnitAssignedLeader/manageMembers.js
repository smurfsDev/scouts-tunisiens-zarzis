const manageMembersSubs = () => import("@/views/UnitAssignedLeader/manageMembers.vue");

export default [
  {
    path: "/manageMembersSubs",
    component: manageMembersSubs,
    name: "manageMembersSubs",
    meta: {requiresMoneyManager: true},
  },
];
