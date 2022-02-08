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
  async allowUserSignUp() {
    const { data } = await Vue.axios.get("settings/allow-user-sign-up");
    // @ts-ignore
    return data.allow_user_sign_up;
  },
  async updateSettings(options, payload) {
    await Vue.axios.put(`settings`, payload);
  },
  async getPages(options, payload = {}) {
    const { data } = await Vue.axios.get(`settings/pages`, { params: payload });
    return data;
  },
  async savePages(options, payload = {}) {
    await Vue.axios.post(`settings/pages`, payload);
  },
  async deleteBlock(options, { pageId, blockId }) {
    await Vue.axios.delete(`settings/pages/${pageId}/blocks/${blockId}`);
  },
  async deletePage(options, pageId) {
    await Vue.axios.delete(`settings/pages/${pageId}`);
  },
};

export const SettingsStoreModule: Module<SettingsState, RootState> = {
  state,
  getters,
  mutations,
  actions,
  namespaced: true,
};
