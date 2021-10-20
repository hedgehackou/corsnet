import { Module } from "vuex";
import { InstallState } from "@/modules/install/store/types";
import { GetterTree, ActionTree, MutationTree } from "vuex";
import { RootState } from "@/store/types";
import Vue from "vue";

const state: InstallState = {};

const getters: GetterTree<InstallState, RootState> = {};

const mutations: MutationTree<InstallState> = {};

const actions: ActionTree<InstallState, RootState> = {
  async isProjectInstalled() {
    const response = await Vue.axios.get(`install/is-project-installed`);

    return response.data;
  },
  async connectToDatabase(options, payload) {
    const response = await Vue.axios.post(
      `install/connect-to-database`,
      payload
    );
    return response.data;
  },
  async setupSmtp(options, payload) {
    const response = await Vue.axios.post(`install/setup-smtp`, payload);

    return response.data;
  },
  async addSettings(options, payload) {
    const response = await Vue.axios.post(`install/add-settings`, payload);

    return response.data;
  },
  async addAdminParams(options, payload) {
    const response = await Vue.axios.post(`install/add-admin`, payload);

    return response.data;
  },
  async installation(options, payload) {
    const response = await Vue.axios.post(`install/installation`, payload);

    return response.data;
  },
};

export const InstallStoreModule: Module<InstallState, RootState> = {
  state,
  getters,
  mutations,
  actions,
  namespaced: true,
};
