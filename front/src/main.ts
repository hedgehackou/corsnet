import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import i18n from "./i18n";
import Loading from "vue-loading-overlay";
import axios from "axios";
import VueAxios from "vue-axios";
import VueToast from "vue-toast-notification";
import { BootstrapVue } from "bootstrap-vue";
import FormErrorListPrinter from "@/components/form/FormErrorListPrinter.vue";
import { BaseMixin } from "@/mixins/BaseMixin";
import VueMoment from "vue-moment";
import moment from "moment";
//@ts-ignore
import Editor from "v-markdown-editor";

Vue.config.productionTip = false;
axios.defaults.baseURL = process.env.VUE_APP_BASE_API_URL;
if (localStorage.getItem("auth_token")) {
  axios.defaults.headers = {
    // @ts-ignore
    Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
    Accept: "application/json",
  };
}

Vue.component("form-error-list-printer", FormErrorListPrinter);
Vue.use(Loading);
Vue.use(Editor);
Vue.use(BootstrapVue);
Vue.use(VueAxios, axios);
Vue.use(VueToast, { position: "top-right", duration: 3000 });
Vue.use(VueMoment, moment);
Vue.mixin(BaseMixin);

new Vue({
  router,
  store,
  i18n,
  render: (h) => h(App),
}).$mount("#app");
