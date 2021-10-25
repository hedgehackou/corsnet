import { Module } from "vuex";
import { AuthState } from "./types";
import { GetterTree, ActionTree, MutationTree } from "vuex";
import { RootState } from "@/store/types";
import Vue from "vue";

const state: AuthState = {
  isAuthorized: false,
  user: {},
};

const getters: GetterTree<AuthState, RootState> = {
  isAuthorized(state: AuthState) {
    return state.isAuthorized;
  },
};

const mutations: MutationTree<AuthState> = {
  auth(state, value) {
    state.isAuthorized = value;
  },
  user(state, value) {
    state.user = value;
  },
};

const actions: ActionTree<AuthState, RootState> = {
  async login(options, payload) {
    const response = await Vue.axios.post(`auth/login`, payload);

    return response.data;
  },
  async fetchProfile({ commit }) {
    try {
      const response = await Vue.axios.post(`auth/fetch-profile`);
      console.log("response", response.data);
      commit("auth", true);
      commit("user", response.data);
    } catch (e) {
      commit("auth", false);
    }
  },
};

export const AuthStoreModule: Module<AuthState, RootState> = {
  state,
  getters,
  mutations,
  actions,
  namespaced: true,
};
