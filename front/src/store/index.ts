import Vue from "vue";
import Vuex from "vuex";
import { InstallStoreModule } from "@/modules/install/store/InstallStore";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {},
  mutations: {},
  actions: {},
  modules: {
    InstallStore: InstallStoreModule,
  },
});
