import { Module } from "vuex";
import { InviteState } from "./types";
import { GetterTree, ActionTree, MutationTree } from "vuex";
import { RootState } from "@/store/types";
import Vue from "vue";

const state: InviteState = {
  inviteList: [],
  currentPage: 1,
  perPage: 10,
  total: 0,
};

const getters: GetterTree<InviteState, RootState> = {
  getInviteList(state) {
    return state.inviteList;
  },
  getCurrentPage(state) {
    return state.currentPage;
  },
  getPerPage(state) {
    return state.perPage;
  },
  getTotal(state) {
    return state.total;
  },
};

const mutations: MutationTree<InviteState> = {
  setInviteList(state, { list, total, per_page, current_page }) {
    state.inviteList = list;
    state.total = total;
    state.perPage = per_page;
    state.currentPage = current_page;
  },
};

const actions: ActionTree<InviteState, RootState> = {
  async getInviteInfo(options, token) {
    const response = await Vue.axios.get(`invites/${token}`);

    return response.data;
  },
  async getInviteList(options, payload = {}) {
    const { data } = await Vue.axios.get(`invites`, { params: payload });
    options.commit("setInviteList", data);
  },
  async createInvite(options, payload) {
    await Vue.axios.post(`invites`, payload);
  },
  async acceptInvite(options, payload) {
    await Vue.axios.post(`invites/accept`, payload);
  },
};

export const InviteStoreModule: Module<InviteState, RootState> = {
  state,
  getters,
  mutations,
  actions,
  namespaced: true,
};
