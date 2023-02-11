import Vue from "vue";
import "./plugins/axios";
import "./plugins/bootstrap-vue";
import App from "./App.vue";
import router from "./router/metaRouter";
import store from "./store";
import vuetify from "./plugins/vuetify";
import Vuelidate from "./plugins/vuelidate";
import "material-design-icons-iconfont/dist/material-design-icons.css";
import interceptorsSetup from "./helpers/interceptors";
Vue.config.productionTip = false;
import VueCompositionAPI from "@vue/composition-api";
interceptorsSetup();

new Vue({
  Vuelidate,
  router,
  store,
  vuetify,
  VueCompositionAPI,
  render: (h) => h(App),
}).$mount("#app");
