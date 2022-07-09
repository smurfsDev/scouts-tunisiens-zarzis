const demandeMateriel = () => import("@/views/DemandeMateriel.vue");

export default [
  {
    path: "/demandeMateriel",
    component: demandeMateriel,
    name: "demandeMateriel",
    meta: {requiresLeader: true},
  },
];
