import { Module } from "vuex";
import { SettingsState } from "./types";
import { GetterTree, ActionTree, MutationTree } from "vuex";
import { RootState } from "@/store/types";
import Vue from "vue";

const state: SettingsState = {};

const getters: GetterTree<SettingsState, RootState> = {};

const mutations: MutationTree<SettingsState> = {};

const actions: ActionTree<SettingsState, RootState> = {
  async getSettings(options, payload = {}) {
    const { data } = await Vue.axios.get(`settings`, { params: payload });
    return data;
  },
  async updateSettings(options, payload) {
    await Vue.axios.put(`settings`, payload);
  },
};

export const SettingsStoreModule: Module<SettingsState, RootState> = {
  state,
  getters,
  mutations,
  actions,
  namespaced: true,
};
