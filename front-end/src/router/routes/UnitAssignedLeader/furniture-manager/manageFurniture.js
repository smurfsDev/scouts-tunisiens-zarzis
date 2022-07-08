const manageFurniture = () => import("@/views/UnitAssignedLeader/furniture-manager/manageFurniture.vue");

export default [
  {
    path: "/manageFurniture",
    component: manageFurniture,
    name: "manageFurniture",
    meta: {requiresFurnitureManager: true},
  },
];
