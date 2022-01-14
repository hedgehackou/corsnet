import { Module } from "vuex";
import { CasterState } from "./types";
import { GetterTree, ActionTree, MutationTree } from "vuex";
import { RootState } from "@/store/types";
import Vue from "vue";

const state: CasterState = {
  countryList: [],
  casterList: [],
  currentPage: 1,
  perPage: 10,
  total: 0,
};

const getters: GetterTree<CasterState, RootState> = {
  getCasterList(state) {
    return state.casterList;
  },
  getCountries(state) {
    return state.countryList;
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

const mutations: MutationTree<CasterState> = {
  setCasterList(state, { list, total, per_page, current_page }) {
    state.casterList = list;
    state.total = total;
    state.perPage = per_page;
    state.currentPage = current_page;
  },
  setCountries(state, { list }) {
    state.countryList = list.map((item: any) => ({
      text: item.alpha_2,
      value: item.id,
    }));
  },
};

const actions: ActionTree<CasterState, RootState> = {
  async getCaster(options, id) {
    const response = await Vue.axios.get(`casters/${id}`);

    return response.data;
  },
  async getCasterList(options, payload = {}) {
    const { data } = await Vue.axios.get(`casters`, { params: payload });
    options.commit("setCasterList", data);
  },
  async getCountries(options, payload = {}) {
    const { data } = await Vue.axios.get(`countries`, {
      params: payload,
    });
    options.commit("setCountries", data);
  },
  async createCaster(options, payload) {
    await Vue.axios.post(`casters`, payload);
  },
  async updateCaster(options, payload) {
    await Vue.axios.put(`casters/${payload.casterId}`, payload);
  },
  async deleteCaster(options, casterId) {
    await Vue.axios.delete(`casters/${casterId}`);
  },
};

export const CasterStoreModule: Module<CasterState, RootState> = {
  state,
  getters,
  mutations,
  actions,
  namespaced: true,
};
