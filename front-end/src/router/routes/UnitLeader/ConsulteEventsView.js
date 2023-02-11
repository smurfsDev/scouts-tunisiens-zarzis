const manageEvents = () => import("@/views/UnitLeader/ConsulteEventsView.vue");

export default [
  {
    path: "/manageEvents",
    component: manageEvents,
    name: "manageEvents",
    meta: { requiresUnitLeader: true },
  },
];
