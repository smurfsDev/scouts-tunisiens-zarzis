import router from "./index";
import store from "../store";
router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (store.getters.isLoggedIn) {
      next();
      return;
    }
    next({ name: "login", params: { msg: "للدخول لهذه الصغحة يجب ان تسجل دخولك" } });
  } else {
    next();
  }
  if (to.matched.some((record) => record.meta.guest)) {
    if (store.getters.isLoggedIn) {
      next({ name: "login", params: { msg: "للدخول لهذه الصغحة يجب ان لا تسجل دخولك" } });
    }
    next();
  } else if (to.matched.some((record) => record.meta.requiresSuperAdmin)) {
    if (store.getters.isSuperAdmin) {
      next();
      return;
    }
    next({
      name: "login",
      params: { msg: "ليس لديك صلاحيات قائد الفوج للدخول لهذا الرابط." },
    });
  }else if (to.matched.some((record) => record.meta.requiresUnitLeader)) {
    if (store.getters.isUnitLeader) {
      next();
      return;
    }
    next({
      name: "login",
      params: { msg: "ليس لديك صلاحيات قائد وحدة للدخول لهذا الرابط." },
    });
  }else if (to.matched.some((record) => record.meta.requiresMoneyManager)) {
    if (store.getters.responsability === "money-manager") {
      next();
      return;
    }
    next({
      name: "login",
      params: { msg: "ليس لديك صلاحيات امين مال للدخول لهذا الرابط." },
    });
  }else if (to.matched.some((record) => record.meta.requiresFurnitureManager)) {
    if (store.getters.responsability === "furniture-manager") {
      next();
      return;
    }
    next({
      name: "login",
      params: { msg: "ليس لديك صلاحيات مسؤول عن الاثاث للدخول لهذا الرابط." },
    });
  } else {
    next();
  }
});

export default router;
