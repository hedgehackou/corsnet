<template>
  <section class="content">
    <div class="container-fluid overflow-hidden">
      <div class="">
        <div class="form-group mb-0">
          <div class="mt-2">{{ $t("baseStations.name") }}</div>
          <b-input
            v-model="baseStationParams.name"
            type="text"
            class="form-control mt-1"
          />
        </div>
        <form-error-list-printer :error-list="baseStationErrors.name" />
        <div class="form-group mb-0">
          <div class="mt-2">{{ $t("baseStations.city") }}</div>
          <b-input
            v-model="baseStationParams.city"
            type="text"
            class="form-control mt-1"
          />
        </div>
        <form-error-list-printer :error-list="baseStationErrors.city" />
        <div class="form-group mb-0">
          <div class="mt-2">{{ $t("baseStations.latitude") }}</div>
          <b-input
            v-model="baseStationParams.latitude"
            type="number"
            class="form-control mt-1"
          />
        </div>
        <form-error-list-printer :error-list="baseStationErrors.latitude" />
        <div class="form-group mb-0">
          <div class="mt-2">{{ $t("baseStations.longitude") }}</div>
          <b-input
            v-model="baseStationParams.longitude"
            type="number"
            class="form-control mt-1"
          />
        </div>
        <form-error-list-printer :error-list="baseStationErrors.longitude" />
        <div class="form-group mb-0">
          <div class="mt-2">{{ $t("baseStations.height") }}</div>
          <b-input
            v-model="baseStationParams.height"
            type="number"
            class="form-control mt-1"
          />
        </div>
        <form-error-list-printer :error-list="baseStationErrors.height" />
        <div class="form-group mb-0">
          <div class="mt-2">{{ $t("baseStations.isOnline") }}</div>
          <b-check v-model="baseStationParams.is_online"></b-check>
        </div>
        <form-error-list-printer :error-list="baseStationErrors.is_online" />
        <div class="form-group mb-0">
          <div class="mt-2">{{ $t("baseStations.status") }}</div>
          <b-select
            :options="statusOptions"
            v-model="baseStationParams.status"
          ></b-select>
        </div>
        <form-error-list-printer :error-list="baseStationErrors.status" />

        <b-button
          v-if="editMode"
          @click="saveBaseStation"
          class="mb-3 mt-3"
          variant="primary"
          >{{ $t("baseStations.save") }}</b-button
        >
        <b-button
          v-else
          @click="createBaseStation"
          class="mb-3 mt-3"
          variant="primary"
          >{{ $t("baseStations.create") }}</b-button
        >
      </div>
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Prop, Vue } from "vue-property-decorator";
import FormErrorListPrinter from "@/components/form/FormErrorListPrinter.vue";
import { namespace } from "vuex-class";
import StoreModule from "@/store/StoreModule";

import { BaseStationStoreModule } from "@/modules/admin/base-stations/store/BaseStationStore";

const authStore = namespace("AuthStoreModule");
const baseStationStore = namespace("BaseStationStoreModule");
StoreModule.registerMany({
  BaseStationStoreModule,
});

@Component({
  components: {
    FormErrorListPrinter,
  },
})
export default class CreateEditBaseStation extends Vue {
  @Prop({ type: Boolean, required: false, default: false })
  readonly editMode: any;

  @Prop({ type: Number, required: false, default: null })
  readonly baseStationId: any;

  public baseStationDefaultParams = {
    name: null,
    city: null,
    latitude: null,
    longitude: null,
    height: null,
    is_online: null,
    status: null,
  };
  public baseStationParams = { ...this.baseStationDefaultParams };
  public baseStationErrors = { ...this.baseStationDefaultParams };
  public statusOptions = [
    { value: "active", text: "Active" },
    { value: "disabled", text: "Disabled" },
  ];

  @authStore.Getter("getRole")
  public role!: string;

  @baseStationStore.Action("createBaseStation")
  createBaseStationAction!: (payload: any) => Promise<any>;

  @baseStationStore.Action("updateBaseStation")
  updateBaseStationAction!: (payload: any) => Promise<any>;

  @baseStationStore.Action("getBaseStation")
  getBaseStationAction!: (id: any) => Promise<any>;

  public async saveBaseStation() {
    this.baseStationErrors = { ...this.baseStationDefaultParams };
    let loader = this.$loading.show();
    try {
      await this.updateBaseStationAction({
        ...this.baseStationParams,
        baseStationId: this.baseStationId,
      });
      this.$toast.success(this.$t("baseStations.success") as string);
    } catch (e) {
      this.$toast.error(this.$t("baseStations.error") as string);
      this.baseStationErrors = e.response.data.errors;
    } finally {
      loader.hide();
    }
  }

  public async createBaseStation() {
    this.baseStationErrors = { ...this.baseStationDefaultParams };
    let loader = this.$loading.show();
    try {
      await this.createBaseStationAction(this.baseStationParams);
      this.$toast.success(this.$t("baseStations.success") as string);
      await this.$router.push({ name: `${this.role}-base-stations` });
    } catch (e) {
      this.$toast.error(this.$t("baseStations.error") as string);
      this.baseStationErrors = e.response.data.errors;
    } finally {
      loader.hide();
    }
  }

  public async mounted() {
    if (this.editMode) {
      const { data: result } = await this.getBaseStationAction(
        this.baseStationId
      );
      Object.assign(this.baseStationParams, result);
    }
  }
}
</script>
