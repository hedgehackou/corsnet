<template>
  <section class="content">
    <div class="container-fluid overflow-hidden">
      <div>
        <b-card
          v-for="(receiver, index) in receivers"
          :key="index"
          no-body
          class="mb-1 mt-4"
        >
          <b-card-header header-tag="header" class="p-1" role="tab">
            <b-button
              @click.prevent="receiver.isShow = !receiver.isShow"
              block
              variant="info"
              class="d-flex align-items-center"
            >
              <div>
                <div>{{ receiver.name }}</div>
              </div>
              <b-btn
                @click.prevent.stop=""
                class="ml-auto"
                size="sm"
                variant="danger"
                ><i class="fa fa-trash"></i
              ></b-btn>
            </b-button>
          </b-card-header>
          <b-collapse v-model="receiver.isShow">
            <b-card-body>
              <div>{{ $t("receiver.model") }}</div>
              <b-input v-model="receiver.name" />
              <form-error-list-printer :error-list="receiverErrors().name" />
              <div>{{ $t("receiver.model") }}</div>
              <b-input v-model="receiver.model" />
              <form-error-list-printer :error-list="receiverErrors().model" />
              <div class="mt-3">{{ $t("receiver.serialNumber") }}</div>
              <b-input class="" v-model="receiver.serial_number" />
              <form-error-list-printer :error-list="[]" />
              <div class="mt-3">{{ $t("receiver.firmwareVersion") }}</div>
              <b-input class="" v-model="receiver.firmware_version" />
              <form-error-list-printer :error-list="[]" />
              <div class="mt-3">{{ $t("receiver.cutoff") }}</div>
              <b-input class="" v-model="receiver.cutoff" />
              <form-error-list-printer :error-list="[]" />
              <div class="mt-3">{{ $t("receiver.installedAt") }}</div>
              <DatePicker
                type="datetime"
                :show-time-header="true"
                class="w-100"
                v-model="receiver.installed_at"
              />
              <form-error-list-printer :error-list="[]" />
              <div class="mt-3">{{ $t("receiver.removedAt") }}</div>
              <DatePicker
                type="datetime"
                :show-time-header="true"
                class="w-100"
                v-model="receiver.removed_at"
              />
              <form-error-list-printer :error-list="[]" />
            </b-card-body>
          </b-collapse>
        </b-card>
      </div>
      <b-btn @click="addReceiver" variant="primary" class="mt-3 mb-3">{{
        $t("receivers.addReceiver")
      }}</b-btn>
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import FormErrorListPrinter from "@/components/form/FormErrorListPrinter.vue";
import { namespace } from "vuex-class";
import StoreModule from "@/store/StoreModule";
// @ts-ignore
import DatePicker from "vue2-datepicker";

import { BaseStationStoreModule } from "@/modules/admin/base-stations/store/BaseStationStore";

const baseStationStore = namespace("BaseStationStoreModule");
StoreModule.registerMany({
  BaseStationStoreModule,
});

@Component({
  components: {
    FormErrorListPrinter,
    DatePicker,
  },
})
export default class Receivers extends Vue {
  public receivers: any = [];

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

  @baseStationStore.Action("createBaseStation")
  createBaseStationAction!: (payload: any) => Promise<any>;

  public async createBaseStation() {
    this.baseStationErrors = { ...this.baseStationDefaultParams };
    let loader = this.$loading.show();
    try {
      await this.createBaseStationAction(this.baseStationParams);
      this.$toast.success(this.$t("baseStations.success") as string);
      await this.$router.push({ name: "base-stations" });
    } catch (e) {
      this.$toast.error(this.$t("baseStations.error") as string);
      this.baseStationErrors = e.response.data.errors;
    } finally {
      loader.hide();
    }
  }

  public receiverErrors() {
    return {};
  }

  public async addReceiver() {
    this.receivers.push({
      isShow: true,
      name: null,
      city: null,
      latitude: null,
    });
  }
}
</script>
