const requestDocument = () =>
  import("@/views/UnitAssignedLeader/general-manager/RequestDocuments.vue");

export default [
  {
    path: "/requestDocument",
    component: requestDocument,
    name: "requestDocument",
    meta: { requiresGeneralManager: true },
  },
];
