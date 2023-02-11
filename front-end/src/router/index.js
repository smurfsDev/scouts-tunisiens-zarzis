import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/HomeView.vue";
import Login from "./routes/auth/login";
import Register from "./routes/auth/register";
import Logout from "./routes/auth/logout";
import ManageLeaders from "./routes/Admin/manageLeaders";
import ManageMembers from "./routes/UnitLeader/manageMembers";
import ManageMembersSubs from "./routes/UnitAssignedLeader/money-manager/manageMembers";
import VerifyEmail from "./routes/auth/emailVerifyingProcess";
import RequestVerifyEmail from "./routes/auth/requestVerifyEmail";
import ResetPassword from "./routes/auth/resetPassword/reset-password";
import ForgotPassword from "./routes/auth/resetPassword/forgot-password";
import ManageMateriel from "./routes/UnitAssignedLeader/materiel-manager/manageMateriel";
import manageDemandeMateriel from "./routes/UnitAssignedLeader/materiel-manager/manageDemandeMateriel";
import DemandeMateriel from "./routes/DemandeMateriel";
import manageTroops from "./routes/Admin/manageTroops";
import profile from "./routes/auth/profile";
import requestDocument from "./routes/UnitAssignedLeader/general-manager/requestDocuments";
import manageRequestDocumnt from "./routes/Admin/managerRequestDocument";
import manageEventSuperAdmin from "./routes/Admin/manegeEventSuperAdmin.js";
import manageEvents from "./routes/UnitLeader/ConsulteEventsView.js";
Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "Home",
    component: Home,
  },

  ...Login,
  ...Register,
  ...Logout,
  ...ManageLeaders,
  ...ManageMembers,
  ...VerifyEmail,
  ...RequestVerifyEmail,
  ...ResetPassword,
  ...ForgotPassword,
  ...profile,
  ...ManageMembersSubs,
  ...ManageMateriel,
  ...DemandeMateriel,
  ...manageDemandeMateriel,
  ...manageTroops,
  ...requestDocument,
  ...manageRequestDocumnt,
  ...manageEvents,
  ...manageEventSuperAdmin,
];

const router = new VueRouter({
  mode: "history",
  routes,
});

export default router;
