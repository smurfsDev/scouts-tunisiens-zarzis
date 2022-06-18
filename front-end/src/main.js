import Vue from "vue";
import "./plugins/axios";
import "./plugins/bootstrap-vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import vuetify from "./plugins/vuetify";
import Vuelidate from './plugins/vuelidate';
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import interceptorsSetup from './helpers/interceptors';
Vue.config.productionTip = false;
interceptorsSetup()

new Vue({
  Vuelidate,
  router,
  store,
  vuetify,
  render: (h) => h(App),
}).$mount("#app");
