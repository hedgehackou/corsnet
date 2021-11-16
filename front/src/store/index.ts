import Vue from "vue";
import Vuex from "vuex";
import { InstallStoreModule } from "@/modules/install/store/InstallStore";
import { AuthStoreModule } from "@/modules/auth/store/AuthStore";
import { calculateWindowSize } from "@/utils/helpers";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    isSidebarMenuCollapsed: false,
    screenSize: calculateWindowSize(window.innerWidth),
  },
  mutations: {
    toggleSidebarMenu: (state: any): void => {
      state.isSidebarMenuCollapsed = !state.isSidebarMenuCollapsed;
    },
    setWindowSize: (state: any, payload: string): void => {
      state.screenSize = payload;
    },
  },
  getters: {
    isSidebarMenuCollapsed: (state: any): boolean =>
      state.isSidebarMenuCollapsed,
    screenSize: (state: any): boolean => state.screenSize,
  },
  actions: {
    toggleSidebarMenu: (context: any): any => {
      context.commit("toggleSidebarMenu");
    },
    setWindowSize: (context: any, payload: string): void => {
      context.commit("setWindowSize", payload);
    },
  },
  modules: {
    InstallStore: InstallStoreModule,
    AuthStore: AuthStoreModule,
  },
});
