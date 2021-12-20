<template>
  <section class="content">
    <div class="container-fluid overflow-hidden">
      <div class="antenna-card-wrapper">
        <b-card
          v-for="(antenna, index) in antennas"
          :key="index"
          no-body
          class="mb-1 mt-4"
        >
          <b-card-header header-tag="header" class="p-1" role="tab">
            <b-button
              @click.prevent="antenna.isShow = !antenna.isShow"
              block
              variant="info"
              class="d-flex align-items-center"
            >
              <div class="d-flex align-items-center">
                <div class="fa fa-minus" v-if="antenna.isShow"></div>
                <div class="fa fa-plus" v-else></div>
                <div class="ml-2">
                  GNSS {{ $t("antenna.antenna") }}
                  {{ showAntennaDate(antenna) }}
                </div>
              </div>
              <b-btn
                v-if="antenna.id && role === 'admin'"
                @click.prevent.stop="antenna.disabled = !antenna.disabled"
                class="ml-auto"
                size="sm"
                variant="primary"
                ><i class="fa fa-pencil-alt"></i
              ></b-btn>
              <b-btn
                v-if="role === 'admin'"
                @click.prevent.stop="removeAntenna(antenna)"
                :class="antenna.id ? 'ml-2' : 'ml-auto'"
                size="sm"
                variant="danger"
                ><i class="fa fa-trash"></i
              ></b-btn>
            </b-button>
          </b-card-header>
          <b-collapse v-model="antenna.isShow">
            <b-card-body>
              <div>{{ $t("antenna.model") }}</div>
              <b-input
                size="sm"
                v-model="antenna.model"
                :disabled="antenna.disabled"
              />
              <form-error-list-printer
                :error-list="
                  antennaErrors[index] ? antennaErrors[index].model : []
                "
              />
              <div class="mt-3">{{ $t("antenna.serialNumber") }}</div>
              <b-input
                size="sm"
                class=""
                :disabled="antenna.disabled"
                v-model="antenna.serial_number"
              />
              <form-error-list-printer
                :error-list="
                  antennaErrors[index] ? antennaErrors[index].serial_number : []
                "
              />
              <div class="mt-3">{{ $t("antenna.upEccentricity") }}</div>
              <b-input
                type="number"
                size="sm"
                :disabled="antenna.disabled"
                class=""
                v-model="antenna.up_eccentricity"
              />
              <form-error-list-printer
                :error-list="
                  antennaErrors[index]
                    ? antennaErrors[index].up_eccentricity
                    : []
                "
              />
              <div class="mt-3">{{ $t("antenna.northEccentricity") }}</div>
              <b-input
                type="number"
                size="sm"
                :disabled="antenna.disabled"
                class=""
                v-model="antenna.north_eccentricity"
              />
              <form-error-list-printer
                :error-list="
                  antennaErrors[index]
                    ? antennaErrors[index].north_eccentricity
                    : []
                "
              />
              <div class="mt-3">{{ $t("antenna.eastEccentricity") }}</div>
              <b-input
                type="number"
                size="sm"
                :disabled="antenna.disabled"
                class=""
                v-model="antenna.east_eccentricity"
              />
              <form-error-list-printer
                :error-list="
                  antennaErrors[index]
                    ? antennaErrors[index].east_eccentricity
                    : []
                "
              />
              <div class="mt-3">{{ $t("antenna.alignment") }}</div>
              <b-input
                type="number"
                size="sm"
                :disabled="antenna.disabled"
                class=""
                v-model="antenna.alignment"
              />
              <form-error-list-printer
                :error-list="
                  antennaErrors[index] ? antennaErrors[index].alignment : []
                "
              />
              <div class="mt-3">{{ $t("antenna.installedAt") }}</div>
              <DatePicker
                :disabled="antenna.disabled"
                type="datetime"
                value-type="YYYY-MM-DD HH:mm:ss"
                :show-time-header="true"
                class="w-100"
                v-model="antenna.installed_at"
              />
              <form-error-list-printer
                :error-list="
                  antennaErrors[index] ? antennaErrors[index].installed_at : []
                "
              />
              <div class="mt-3">{{ $t("antenna.removedAt") }}</div>
              <DatePicker
                :disabled="antenna.disabled"
                type="datetime"
                value-type="YYYY-MM-DD HH:mm:ss"
                :show-time-header="true"
                class="w-100"
                v-model="antenna.removed_at"
              />
              <form-error-list-printer
                :error-list="
                  antennaErrors[index] ? antennaErrors[index].removed_at : []
                "
              />
              <div class="d-flex">
                <b-btn
                  v-if="!antenna.disabled && role === 'admin'"
                  size="sm"
                  @click="saveAntenna(antenna, index)"
                  variant="primary"
                  class="mt-3 ml-auto"
                  >{{ $t("index.save") }}</b-btn
                >
              </div>
            </b-card-body>
          </b-collapse>
        </b-card>
      </div>
      <b-btn
        v-if="role === 'admin'"
        @click="addAntenna"
        variant="primary"
        class="mt-3 mb-3"
        >{{ $t("antenna.addAntenna") }}</b-btn
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
export default class Antennas extends Vue {
  public antennas: any = [];

  public antennaDefaultParams = {
    disabled: false,
    isShow: true,
    model: null,
    serial_number: null,
    up_eccentricity: null,
    north_eccentricity: null,
    east_eccentricity: null,
    alignment: null,
    installed_at: null,
    removed_at: null,
  };
  public antennaErrors: any = {};

  @authStore.Getter("getRole")
  public role!: string;

  @baseStationStore.Action("deleteAntenna")
  deleteAntennaAction!: (payload: any) => Promise<any>;

  @baseStationStore.Action("createAntenna")
  createAntennaAction!: (receiver: any) => Promise<any>;

  @baseStationStore.Action("updateAntenna")
  updateAntennaAction!: (antenna: any) => Promise<any>;

  @baseStationStore.Action("getAntennas")
  getAntennasAction!: (antenna: any) => Promise<any>;

  showAntennaDate(antenna: any) {
    //@ts-ignore
    const start = this.$moment(antenna.installed_at).format("YYYY-MM-DD");
    //@ts-ignore
    const end = this.$moment(antenna.removed_at).format("YYYY-MM-DD");
    if (antenna.installed_at && antenna.removed_at) {
      return `(${start} - ${end})`;
    }
    if (antenna.installed_at) {
      return `(${(this.$t("index.since") as string).toLowerCase()} ${start})`;
    }
    return "";
  }

  async removeAntenna(antenna: any) {
    this.$bvModal
      .msgBoxConfirm(this.$t("antenna.deleteAntenna") as string, {
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
            if (antenna.id) {
              await this.deleteAntennaAction({
                id: antenna.id,
                baseStationId: this.$route.params.baseStationId,
              });
            }
            this.antennas.splice(this.antennas.indexOf(antenna), 1);
          } finally {
            loader.hide();
          }
        }
      });
  }

  public async saveAntenna(antenna: any, index: number) {
    let loader = this.$loading.show();
    try {
      this.$set(this.antennaErrors, index, {});
      antenna.baseStationId = this.$route.params.baseStationId;
      if (antenna.id) {
        await this.updateAntennaAction(antenna);
      } else {
        let { data } = await this.createAntennaAction(antenna);
        antenna.id = data.data.id;
        antenna.disabled = true;
      }
      this.$toast.success(this.$t("antenna.savedSuccessfully") as string);
    } catch (e) {
      this.$toast.error(this.$t("antenna.error") as string);
      this.$set(this.antennaErrors, index, e.response.data.errors);
    } finally {
      loader.hide();
    }
  }

  public async addAntenna() {
    this.antennas.push(Object.assign({}, this.antennaDefaultParams));
  }

  mounted() {
    this.getAntennasAction(this.$route.params.baseStationId).then(
      ({ data }) => {
        this.antennas = data.list;
      }
    );
  }
}
</script>

<style lang="scss">
.antenna-card-wrapper {
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
