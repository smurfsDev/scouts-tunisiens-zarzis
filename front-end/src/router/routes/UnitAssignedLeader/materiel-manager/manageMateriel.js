const manageMateriel = () =>
  import("@/views/UnitAssignedLeader/materiel-manager/manageMateriel.vue");

export default [
  {
    path: "/manageMateriel",
    component: manageMateriel,
    name: "manageMateriel",
    meta: { requiresMaterielManager: true },
  },
];
