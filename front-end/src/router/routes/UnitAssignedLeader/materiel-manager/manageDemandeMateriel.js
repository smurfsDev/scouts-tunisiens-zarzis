const manageDemandeMateriel = () => import("@/views/UnitAssignedLeader/materiel-manager/manageDemandeMateriel.vue");

export default [
  {
    path: "/manageDemandeMateriel",
    component: manageDemandeMateriel,
    name: "manageDemandeMateriel",
    meta: {requiresMaterielManager: true},
  },
];