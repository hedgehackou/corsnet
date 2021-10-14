import { Module } from "vuex";
import { InstallState } from "@/modules/install/store/types";
import { GetterTree, ActionTree, MutationTree } from "vuex";
import { RootState } from "@/store/types";
import Vue from "vue";

const state: InstallState = {};

const getters: GetterTree<InstallState, RootState> = {};

const mutations: MutationTree<InstallState> = {};

const actions: ActionTree<InstallState, RootState> = {
  async connectToDatabase(options, payload) {
    const response = await Vue.axios.post(
      `${process.env.VUE_APP_API_URL}/connect-to-database`,
      payload
    );
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
