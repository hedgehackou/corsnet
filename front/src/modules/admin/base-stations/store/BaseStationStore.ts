import { Module } from "vuex";
import { BaseStationState } from "./types";
import { GetterTree, ActionTree, MutationTree } from "vuex";
import { RootState } from "@/store/types";
import Vue from "vue";

const state: BaseStationState = {
  baseStationList: [],
  currentPage: 1,
  perPage: 10,
  total: 0,
};

const getters: GetterTree<BaseStationState, RootState> = {
  getBaseStationList(state) {
    return state.baseStationList;
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

const mutations: MutationTree<BaseStationState> = {
  setBaseStationList(state, { list, total, per_page, current_page }) {
    state.baseStationList = list;
    state.total = total;
    state.perPage = per_page;
    state.currentPage = current_page;
  },
};

const actions: ActionTree<BaseStationState, RootState> = {
  async getBaseStation(options, id) {
    const response = await Vue.axios.get(`base-stations/${id}`);

    return response.data;
  },
  async getBaseStationList(options, payload = {}) {
    const { data } = await Vue.axios.get(`base-stations`, { params: payload });
    options.commit("setBaseStationList", data);
  },
  async createBaseStation(options, payload) {
    await Vue.axios.post(`base-stations`, payload);
  },
  async getSatelliteList(options, baseStationId) {
    return await Vue.axios.get(
      `base-stations/${baseStationId}/receivers/satellite-list`
    );
  },
  async createReceiver(options, receiver) {
    return await Vue.axios.post(
      `base-stations/${receiver.baseStationId}/receivers`,
      receiver
    );
  },
  async createAntenna(options, antenna) {
    return await Vue.axios.post(
      `base-stations/${antenna.baseStationId}/antennas`,
      antenna
    );
  },
  async getReceivers(options, baseStationId) {
    return await Vue.axios.get(`base-stations/${baseStationId}/receivers`);
  },
  async getAntennas(options, baseStationId) {
    return await Vue.axios.get(`base-stations/${baseStationId}/antennas`);
  },
  async updateReceiver(options, receiver) {
    return await Vue.axios.put(
      `base-stations/${receiver.baseStationId}/receivers/${receiver.id}`,
      receiver
    );
  },
  async updateAntenna(options, antenna) {
    return await Vue.axios.put(
      `base-stations/${antenna.baseStationId}/antennas/${antenna.id}`,
      antenna
    );
  },
  async deleteAntenna(options, antenna) {
    return await Vue.axios.delete(
      `base-stations/${antenna.baseStationId}/antennas/${antenna.id}`,
      antenna
    );
  },
  async deleteReceiver(options, receiver) {
    return await Vue.axios.delete(
      `base-stations/${receiver.baseStationId}/receivers/${receiver.id}`,
      receiver
    );
  },
  async updateBaseStation(options, payload) {
    await Vue.axios.put(`base-stations/${payload.baseStationId}`, payload);
  },
  async deleteBaseStation(options, baseStationId) {
    await Vue.axios.delete(`base-stations/${baseStationId}`);
  },
};

export const BaseStationStoreModule: Module<BaseStationState, RootState> = {
  state,
  getters,
  mutations,
  actions,
  namespaced: true,
};
