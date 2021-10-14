import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import i18n from "./i18n";
import Loading from "vue-loading-overlay";
import axios from "axios";
import VueAxios from "vue-axios";
import VueToast from "vue-toast-notification";

Vue.config.productionTip = false;

Vue.use(Loading);
Vue.use(VueAxios, axios);
Vue.use(VueToast, { position: "top-right", duration: 3000 });

new Vue({
  router,
  store,
  i18n,
  render: (h) => h(App),
}).$mount("#app");
