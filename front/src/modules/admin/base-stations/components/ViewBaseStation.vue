<template>
  <section class="content">
    <div class="container-fluid overflow-hidden">
      <div class="base-station-name" v-if="baseStationParams.name">
        <span>{{ baseStationParams.name }}</span>
        <div
          class="base-station-status"
          :class="{
            'base-station-status-green': baseStationParams.is_online,
            'base-station-status-red': !baseStationParams.is_online,
          }"
        ></div>
      </div>
      <b-tabs class="mt-4" content-class="mt-3">
        <b-tab active :title="$t('baseStations.overview')">
          <b-table
            class="base-station-view-table mt-4"
            responsive
            show-empty
            stacked
            :items="tableItems"
            :fields="getBaseStationTableFields"
          >
            <template #cell(is_online)="{ item }">
              <b-check disabled v-model="item.is_online"></b-check>
            </template>
            <template #cell(created_at)="{ item }">
              {{ item.created_at }}
            </template>
          </b-table>
          <div class="">
            <b-button
              v-if="role === 'admin'"
              @click="editBaseStation"
              class="mb-3 mt-3"
              variant="primary"
              >{{ $t("baseStations.edit") }}</b-button
            >
          </div>
        </b-tab>
        <b-tab :title="$t('baseStations.receivers')">
          <Receivers />
        </b-tab>
        <b-tab :title="$t('baseStations.antennas')">
          <Antennas />
        </b-tab>
        <b-tab :title="$t('baseStations.mountPoints')">
          <MountPoints />
        </b-tab>
      </b-tabs>
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Prop, Vue } from "vue-property-decorator";
import FormErrorListPrinter from "@/components/form/FormErrorListPrinter.vue";
import { namespace } from "vuex-class";
import StoreModule from "@/store/StoreModule";

import { BaseStationStoreModule } from "@/modules/admin/base-stations/store/BaseStationStore";
import Receivers from "@/modules/admin/base-stations/components/Receivers.vue";
import Antennas from "@/modules/admin/base-stations/components/Antennas.vue";
import MountPoints from "@/modules/admin/base-stations/components/MountPoints.vue";

const authStore = namespace("AuthStoreModule");
const baseStationStore = namespace("BaseStationStoreModule");
StoreModule.registerMany({
  BaseStationStoreModule,
});

@Component({
  components: {
    FormErrorListPrinter,
    Receivers,
    Antennas,
    MountPoints,
  },
})
export default class ViewBaseStation extends Vue {
  @Prop({ type: Number, required: false, default: null })
  readonly baseStationId: any;

  @authStore.Getter("getRole")
  public role!: string;

  public baseStationParams = {
    name: null,
    city: null,
    latitude: null,
    longitude: null,
    height: null,
    is_online: null,
    status: null,
  };

  public statusOptions = [
    { value: "active", text: "Active" },
    { value: "disabled", text: "Disabled" },
  ];

  @baseStationStore.Action("getBaseStation")
  getBaseStationAction!: (id: any) => Promise<any>;

  public get tableItems() {
    return [this.baseStationParams];
  }

  public get getBaseStationTableFields() {
    return [
      { key: "city", label: this.$t("baseStations.city") + ":" },
      { key: "longitude", label: this.$t("baseStations.longitude") + ":" },
      { key: "latitude", label: this.$t("baseStations.latitude") + ":" },
      { key: "height", label: this.$t("baseStations.height") + ":" },
      { key: "status", label: this.$t("baseStations.status") + ":" },
      { key: "created_at", label: this.$t("baseStations.createdAt") + ":" },
    ];
  }

  public editBaseStation() {
    this.$router.push({
      name: `${this.role}-edit-base-station`,
      params: { baseStationId: this.baseStationId },
    });
  }

  public async mounted() {
    const { data: result } = await this.getBaseStationAction(
      this.baseStationId
    );
    Object.assign(this.baseStationParams, result);
  }
}
</script>

<style lang="scss">
.base-station-view-table {
  td:before {
    width: auto !important;
  }
}
.base-station-name {
  font-size: 18px;
  margin-top: 14px;
  font-weight: bold;
  display: flex;
  align-items: center;
}
.base-station-status {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  margin-left: 5px;
}
.base-station-status-green {
  background-color: green;
}
.base-station-status-red {
  background-color: red;
}
</style>
