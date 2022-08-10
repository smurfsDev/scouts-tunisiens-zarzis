const demandeEvent = () => import("@/views/DemandeEvents.vue");

export default [
    {
        path: "/demandeEvent",
        component: demandeEvent,
        name: "demandeEvent",
        meta: { requiresLeader: true },
    },
];
