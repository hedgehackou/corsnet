import { Module } from "vuex";
import { AuthState } from "./types";
import { GetterTree, ActionTree, MutationTree } from "vuex";
import { RootState } from "@/store/types";
import Vue from "vue";
import axios from "axios";

const state: AuthState = {
  isAuthorized: false,
  user: {},
  settings: {},
};

const getters: GetterTree<AuthState, RootState> = {
  isAuthorized(state: AuthState) {
    return state.isAuthorized;
  },
  userProfile(state: AuthState) {
    return state.user;
  },
};

const mutations: MutationTree<AuthState> = {
  auth(state, value) {
    state.isAuthorized = value;
  },
  user(state, value) {
    state.user = value.data;
  },
  settings(state, value) {
    state.settings = value;
  },
};

const actions: ActionTree<AuthState, RootState> = {
  async login(options, payload) {
    const response = await Vue.axios.post(`auth/login`, payload);

    return response.data;
  },
  async logout({ commit }) {
    localStorage.removeItem("auth_token");
    localStorage.removeItem("auth_abilities");
    commit("user", {});
    commit("auth", false);
    axios.defaults.headers = {
      // @ts-ignore
      Authorization: "",
      Accept: "application/json",
    };
  },
  async sendResetLink(options, payload) {
    const response = await Vue.axios.post(`auth/send-reset-link`, payload);

    return response.data;
  },
  async fetchSettings({ commit, state }) {
    if (Object.keys(state.settings).length) {
      return state.settings;
    }

    const response = await Vue.axios.get(`install/get-project-settings`);
    commit("settings", (response.data as any).data);

    return (response.data as any).data;
  },
  async fetchProfile({ commit }) {
    try {
      const response = await Vue.axios.post(`auth/fetch-profile`);
      commit("auth", true);
      commit("user", response.data);
      return response.data;
    } catch (e) {
      commit("auth", false);
    }
  },
  async resetPassword(options, payload) {
    const response = await Vue.axios.post(`auth/reset-password`, payload);

    return response.data;
  },
};

export const AuthStoreModule: Module<AuthState, RootState> = {
  state,
  getters,
  mutations,
  actions,
  namespaced: true,
};
