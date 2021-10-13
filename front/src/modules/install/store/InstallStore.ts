import { Module } from "vuex";
import { InstallState } from "@/modules/install/store/types";
import { GetterTree, ActionTree, MutationTree } from "vuex";
import { RootState } from "@/store/types";

const state: InstallState = {};

const getters: GetterTree<InstallState, RootState> = {};

const mutations: MutationTree<InstallState> = {};

const actions: ActionTree<InstallState, RootState> = {};

export const InstallStoreModule: Module<InstallState, RootState> = {
  state,
  getters,
  mutations,
  actions,
};
