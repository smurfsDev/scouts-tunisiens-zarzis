const manageRequestDocument = () =>
  import("@/views/Admin/manageRequestDocument.vue");

export default [
  {
    path: "/manageRequestDocument",
    component: manageRequestDocument,
    name: "manageRequestDocument",
    meta: { requiresSuperAdmin: true },
  },
];
