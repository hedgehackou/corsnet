import { Module } from "vuex";
import { UsersState } from "./types";
import { GetterTree, ActionTree, MutationTree } from "vuex";
import { RootState } from "@/store/types";
import Vue from "vue";

const state: UsersState = {
  userList: [],
  currentPage: 1,
  perPage: 10,
  total: 0,
};

const getters: GetterTree<UsersState, RootState> = {
  getUserList(state) {
    return state.userList;
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

const mutations: MutationTree<UsersState> = {
  setUserList(state, { list, total, per_page, current_page }) {
    state.userList = list;
    state.total = total;
    state.perPage = per_page;
    state.currentPage = current_page;
  },
};

const actions: ActionTree<UsersState, RootState> = {
  async getUserList(options, payload = {}) {
    const { data } = await Vue.axios.get(`users`, { params: payload });
    options.commit("setUserList", data);
  },
  async createClient(options, client) {
    return await Vue.axios.post(`users/${client.userId}/clients`, client);
  },
  async getClients(options, userId) {
    return await Vue.axios.get(`users/${userId}/clients`);
  },
  async updateClient(options, client) {
    return await Vue.axios.put(
      `users/${client.userId}/clients/${client.id}`,
      client
    );
  },
  async deleteClient(options, client) {
    return await Vue.axios.delete(
      `users/${client.userId}/clients/${client.id}`,
      client
    );
  },
};

export const UserStoreModule: Module<UsersState, RootState> = {
  state,
  getters,
  mutations,
  actions,
  namespaced: true,
};
