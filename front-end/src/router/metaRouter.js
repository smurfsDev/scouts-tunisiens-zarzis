import router from "./index";
import store from "../store";
router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (store.getters.isLoggedIn) {
      next();
      return;
    }
    next({ name: "login", params: { msg: "Vous devez etre connectée" } });
  } else {
    next();
  }
  if (to.matched.some((record) => record.meta.guest)) {
    if (store.getters.isAuthenticated) {
      next();
      return;
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
  } else {
    next();
  }
});

export default router;
