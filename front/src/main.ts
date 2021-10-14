import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import i18n from "./i18n";
import Loading from "vue-loading-overlay";
import axios from "axios";
import VueAxios from "vue-axios";

Vue.config.productionTip = false;

Vue.use(Loading);
Vue.use(VueAxios, axios);

new Vue({
  router,
  store,
  i18n,
  render: (h) => h(App),
}).$mount("#app");
