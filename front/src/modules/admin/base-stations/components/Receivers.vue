<template>
  <section class="content">
    <div class="container-fluid overflow-hidden">
      <div class="receiver-card-wrapper">
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
              <div class="d-flex align-items-center">
                <div class="fa fa-minus" v-if="receiver.isShow"></div>
                <div class="fa fa-plus" v-else></div>
                <div class="ml-2">
                  GNSS {{ $t("receiver.receiver") }}
                  {{ showReceiverDate(receiver) }}
                </div>
              </div>
              <b-btn
                v-if="receiver.id && role === 'admin'"
                @click.prevent.stop="receiver.disabled = !receiver.disabled"
                class="ml-auto"
                size="sm"
                variant="primary"
                ><i class="fa fa-pencil-alt"></i
              ></b-btn>
              <b-btn
                v-if="role === 'admin'"
                @click.prevent.stop="removeReceiver(receiver)"
                :class="receiver.id ? 'ml-2' : 'ml-auto'"
                size="sm"
                variant="danger"
                ><i class="fa fa-trash"></i
              ></b-btn>
            </b-button>
          </b-card-header>
          <b-collapse v-model="receiver.isShow">
            <b-card-body>
              <div>{{ $t("receiver.model") }}</div>
              <b-input
                size="sm"
                v-model="receiver.model"
                :disabled="receiver.disabled"
              />
              <form-error-list-printer
                :error-list="
                  receiverErrors[index] ? receiverErrors[index].model : []
                "
              />
              <div class="mt-3">{{ $t("receiver.serialNumber") }}</div>
              <b-input
                size="sm"
                class=""
                :disabled="receiver.disabled"
                v-model="receiver.serial_number"
              />
              <form-error-list-printer
                :error-list="
                  receiverErrors[index]
                    ? receiverErrors[index].serial_number
                    : []
                "
              />
              <div class="mt-3">{{ $t("receiver.firmwareVersion") }}</div>
              <b-input
                size="sm"
                class=""
                :disabled="receiver.disabled"
                v-model="receiver.firmware_version"
              />
              <form-error-list-printer
                :error-list="
                  receiverErrors[index]
                    ? receiverErrors[index].firmware_version
                    : []
                "
              />
              <div class="mt-3">{{ $t("receiver.satellites") }}</div>
              <b-form-checkbox-group
                v-model="receiver.satellites"
                name="satellites"
                class="receiver__satellites"
                :disabled="receiver.disabled"
              >
                <label
                  class="receiver__satelliteWrap"
                  v-for="satellite in satellites"
                  :key="satellite.id"
                >
                  <b-check :value="satellite.id" size="sm" class="" />
                  <span class="receiver__satelliteLabel">{{
                    satellite.alias
                  }}</span>
                </label>
              </b-form-checkbox-group>
              <form-error-list-printer
                :error-list="
                  receiverErrors[index] ? receiverErrors[index].satellites : []
                "
              />
              <div class="mt-3">{{ $t("receiver.cutoff") }}</div>
              <b-input
                size="sm"
                :disabled="receiver.disabled"
                class=""
                v-model="receiver.cutoff"
              />
              <form-error-list-printer
                :error-list="
                  receiverErrors[index] ? receiverErrors[index].cutoff : []
                "
              />
              <div class="mt-3">{{ $t("receiver.installedAt") }}</div>
              <DatePicker
                :disabled="receiver.disabled"
                type="datetime"
                value-type="YYYY-MM-DD HH:mm:ss"
                :show-time-header="true"
                class="w-100"
                v-model="receiver.installed_at"
              />
              <form-error-list-printer
                :error-list="
                  receiverErrors[index]
                    ? receiverErrors[index].installed_at
                    : []
                "
              />
              <div class="mt-3">{{ $t("receiver.removedAt") }}</div>
              <DatePicker
                :disabled="receiver.disabled"
                type="datetime"
                value-type="YYYY-MM-DD HH:mm:ss"
                :show-time-header="true"
                class="w-100"
                v-model="receiver.removed_at"
              />
              <form-error-list-printer
                :error-list="
                  receiverErrors[index] ? receiverErrors[index].removed_at : []
                "
              />
              <div class="d-flex">
                <b-btn
                  v-if="!receiver.disabled && role === 'admin'"
                  size="sm"
                  @click="saveReceiver(receiver, index)"
                  variant="primary"
                  class="mt-3 ml-auto"
                  >{{ $t("receiver.save") }}</b-btn
                >
              </div>
            </b-card-body>
          </b-collapse>
        </b-card>
      </div>
      <b-btn
        v-if="role === 'admin'"
        @click="addReceiver"
        variant="primary"
        class="mt-3 mb-3"
        >{{ $t("receiver.addReceiver") }}</b-btn
      >
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
const authStore = namespace("AuthStoreModule");

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
  public satellites: Array<{ id: number; alias: string }> = [];

  public receiverDefaultParams = {
    disabled: false,
    isShow: true,
    model: null,
    serial_number: null,
    firmware_version: null,
    satellites: [],
    cutoff: null,
    installed_at: null,
    removed_at: null,
  };
  public receiverErrors: any = {};

  @authStore.Getter("getRole")
  public role!: string;

  @baseStationStore.Action("deleteReceiver")
  deleteReceiverAction!: (payload: any) => Promise<any>;

  @baseStationStore.Action("getSatelliteList")
  getSatelliteListAction!: (baseStationId: any) => Promise<any>;

  @baseStationStore.Action("createReceiver")
  createReceiverAction!: (receiver: any) => Promise<any>;

  @baseStationStore.Action("updateReceiver")
  updateReceiverAction!: (receiver: any) => Promise<any>;

  @baseStationStore.Action("getReceivers")
  getReceiversAction!: (receiver: any) => Promise<any>;

  showReceiverDate(receiver: any) {
    //@ts-ignore
    const start = this.$moment(receiver.installed_at).format("YYYY-MM-DD");
    //@ts-ignore
    const end = this.$moment(receiver.removed_at).format("YYYY-MM-DD");
    if (receiver.installed_at && receiver.removed_at) {
      return `(${start} - ${end})`;
    }
    if (receiver.installed_at) {
      return `(${(this.$t("index.since") as string).toLowerCase()} ${start})`;
    }
    return "";
  }

  async removeReceiver(receiver: any) {
    this.$bvModal
      .msgBoxConfirm(this.$t("receiver.deleteReceiver") as string, {
        title: this.$t("index.confirm") as string,
        size: "sm",
        buttonSize: "sm",
        okVariant: "danger",
        okTitle: this.$t("index.yes") as string,
        cancelTitle: this.$t("index.no") as string,
        footerClass: "p-2",
        hideHeaderClose: false,
        centered: true,
      })
      .then(async (value) => {
        if (value) {
          let loader = this.$loading.show();
          try {
            if (receiver.id) {
              await this.deleteReceiverAction({
                id: receiver.id,
                baseStationId: this.$route.params.baseStationId,
              });
            }
            this.receivers.splice(this.receivers.indexOf(receiver), 1);
          } finally {
            loader.hide();
          }
        }
      });
  }

  public async saveReceiver(receiver: any, index: number) {
    let loader = this.$loading.show();
    try {
      this.$set(this.receiverErrors, index, {});
      receiver.baseStationId = this.$route.params.baseStationId;
      if (receiver.id) {
        await this.updateReceiverAction(receiver);
      } else {
        let { data } = await this.createReceiverAction(receiver);
        receiver.id = data.data.id;
        receiver.disabled = true;
      }
      this.$toast.success(this.$t("receiver.savedSuccessfully") as string);
    } catch (e) {
      this.$toast.error(this.$t("receiver.error") as string);
      this.$set(this.receiverErrors, index, e.response.data.errors);
    } finally {
      loader.hide();
    }
  }

  public async addReceiver() {
    this.receivers.push(Object.assign({}, this.receiverDefaultParams));
  }

  mounted() {
    this.getSatelliteListAction(this.$route.params.baseStationId).then(
      ({ data }) => {
        this.satellites = data.list;
      }
    );
    this.getReceiversAction(this.$route.params.baseStationId).then(
      ({ data }) => {
        this.receivers = data.list;
      }
    );
  }
}
</script>

<style lang="scss">
.receiver-card-wrapper {
  max-width: 800px;
}
.receiver__satelliteWrap {
  display: flex;
  margin-right: 15px;
  margin-top: 10px;
  .custom-control {
    margin-right: 0;
  }
}
.receiver__satellites {
  display: flex;
  flex-wrap: wrap;
}
.receiver__satelliteLabel {
  position: relative;
  bottom: 2px;
}
</style>
