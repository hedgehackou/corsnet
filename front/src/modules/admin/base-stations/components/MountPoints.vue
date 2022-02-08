<template>
  <section class="content">
    <div class="container-fluid overflow-hidden">
      <div class="mount-point-card-wrapper">
        <b-card
          v-for="(mountPoint, index) in mountPoints"
          :key="index"
          no-body
          class="mb-1 mt-4"
        >
          <b-card-header header-tag="header" class="p-1" role="tab">
            <b-button
              @click.prevent="mountPoint.isShow = !mountPoint.isShow"
              block
              variant="info"
              class="d-flex align-items-center"
            >
              <div class="d-flex align-items-center">
                <div class="fa fa-minus" v-if="mountPoint.isShow"></div>
                <div class="fa fa-plus" v-else></div>
                <div class="ml-2">
                  {{ mountPoint.name }}
                </div>
              </div>
              <b-btn
                v-if="mountPoint.id && role === 'admin'"
                @click.prevent.stop="mountPoint.disabled = !mountPoint.disabled"
                class="ml-auto"
                size="sm"
                variant="primary"
                ><i class="fa fa-pencil-alt"></i
              ></b-btn>
              <b-btn
                v-if="role === 'admin'"
                @click.prevent.stop="removeMountPoint(mountPoint)"
                :class="mountPoint.id ? 'ml-2' : 'ml-auto'"
                size="sm"
                variant="danger"
                ><i class="fa fa-trash"></i
              ></b-btn>
            </b-button>
          </b-card-header>
          <b-collapse v-model="mountPoint.isShow">
            <b-tabs class="mt-0" content-class="mt-3">
              <b-tab :title="$t('mountPoint.info')" active>
                <b-card-body>
                  <div>{{ $t("mountPoint.name") }}</div>
                  <b-input
                    size="sm"
                    v-model="mountPoint.name"
                    :disabled="mountPoint.disabled"
                  />
                  <form-error-list-printer
                    :error-list="
                      mountPointErrors[index]
                        ? mountPointErrors[index].name
                        : []
                    "
                  />
                  <div class="mt-3">{{ $t("mountPoint.userName") }}</div>
                  <b-input
                    size="sm"
                    class=""
                    :disabled="mountPoint.disabled"
                    v-model="mountPoint.user_name"
                  />
                  <form-error-list-printer
                    :error-list="
                      mountPointErrors[index]
                        ? mountPointErrors[index].user_name
                        : []
                    "
                  />
                  <div class="mt-3">{{ $t("mountPoint.password") }}</div>
                  <b-input
                    type="password"
                    size="sm"
                    :disabled="mountPoint.disabled"
                    class=""
                    v-model="mountPoint.password"
                  />
                  <form-error-list-printer
                    :error-list="
                      mountPointErrors[index]
                        ? mountPointErrors[index].password
                        : []
                    "
                  />
                  <div class="mt-3">{{ $t("mountPoint.ntripVersion") }}</div>
                  <b-select
                    :disabled="mountPoint.disabled"
                    :options="ntripVersions"
                    v-model="mountPoint.ntrip_version"
                  ></b-select>
                  <form-error-list-printer
                    :error-list="
                      mountPointErrors[index]
                        ? mountPointErrors[index].ntrip_version
                        : []
                    "
                  />
                  <div class="mt-3">{{ $t("mountPoint.isEncrypted") }}</div>
                  <b-check
                    :disabled="mountPoint.disabled"
                    v-model="mountPoint.is_encrypted"
                    size="sm"
                    class=""
                  />
                  <form-error-list-printer
                    :error-list="
                      mountPointErrors[index]
                        ? mountPointErrors[index].is_encrypted
                        : []
                    "
                  />
                  <div class="d-flex">
                    <b-btn
                      v-if="!mountPoint.disabled && role === 'admin'"
                      size="sm"
                      @click="saveMountPoint(mountPoint, index)"
                      variant="primary"
                      class="mt-3 ml-auto"
                      >{{ $t("index.save") }}</b-btn
                    >
                  </div>
                </b-card-body>
              </b-tab>
              <b-tab :title="$t('mountPoint.description')">
                <b-card-body>
                  <div class="">{{ $t("mountPoint.mountPoint") }}</div>
                  <b-input
                    size="sm"
                    v-model="mountPoint.mountpoint"
                    :disabled="mountPoint.disabled"
                  />
                  <form-error-list-printer
                    :error-list="getMountPointErrors(index, 'mountpoint')"
                  />
                  <div class="mt-3">{{ $t("mountPoint.identifier") }}</div>
                  <b-input
                    size="sm"
                    v-model="mountPoint.identifier"
                    :disabled="mountPoint.disabled"
                  />
                  <form-error-list-printer
                    :error-list="getMountPointErrors(index, 'identifier')"
                  />
                  <div class="mt-3">{{ $t("mountPoint.format") }}</div>
                  <b-input
                    size="sm"
                    v-model="mountPoint.format"
                    :disabled="mountPoint.disabled"
                  />
                  <form-error-list-printer
                    :error-list="getMountPointErrors(index, 'format')"
                  />
                  <div class="mt-3">{{ $t("mountPoint.formatDetails") }}</div>
                  <b-input
                    size="sm"
                    v-model="mountPoint.format_details"
                    :disabled="mountPoint.disabled"
                  />
                  <form-error-list-printer
                    :error-list="getMountPointErrors(index, 'format_details')"
                  />
                  <div class="mt-3">{{ $t("mountPoint.carrier") }}</div>
                  <b-select
                    class="fz-14"
                    size="sm"
                    :disabled="mountPoint.disabled"
                    :options="carrierOptions"
                    v-model="mountPoint.carrier"
                  ></b-select>
                  <form-error-list-printer
                    :error-list="getMountPointErrors(index, 'carrier')"
                  />
                  <div class="mt-3">{{ $t("mountPoint.navSystem") }}</div>
                  <b-input
                    size="sm"
                    v-model="mountPoint.nav_system"
                    :disabled="mountPoint.disabled"
                  />
                  <form-error-list-printer
                    :error-list="getMountPointErrors(index, 'nav_system')"
                  />
                  <div class="mt-3">{{ $t("mountPoint.network") }}</div>
                  <b-input
                    size="sm"
                    v-model="mountPoint.network"
                    :disabled="mountPoint.disabled"
                  />
                  <form-error-list-printer
                    :error-list="getMountPointErrors(index, 'network')"
                  />
                  <div class="mt-3">{{ $t("mountPoint.country") }}</div>
                  <b-select
                    class="fz-14"
                    size="sm"
                    :disabled="mountPoint.disabled"
                    :options="getCountries"
                    text-field="text"
                    value-field="text"
                    v-model="mountPoint.country"
                  ></b-select>
                  <form-error-list-printer
                    :error-list="getMountPointErrors(index, 'country')"
                  />
                  <div class="mt-3">{{ $t("mountPoint.latitude") }}</div>
                  <b-input
                    type="number"
                    size="sm"
                    v-model="mountPoint.latitude"
                    :disabled="mountPoint.disabled"
                  />
                  <form-error-list-printer
                    :error-list="getMountPointErrors(index, 'latitude')"
                  />
                  <div class="mt-3">{{ $t("mountPoint.longitude") }}</div>
                  <b-input
                    type="number"
                    size="sm"
                    v-model="mountPoint.longitude"
                    :disabled="mountPoint.disabled"
                  />
                  <form-error-list-printer
                    :error-list="getMountPointErrors(index, 'longitude')"
                  />
                  <div class="mt-3">{{ $t("mountPoint.nmea") }}</div>
                  <b-select
                    class="fz-14"
                    size="sm"
                    :disabled="mountPoint.disabled"
                    :options="nmeaOptions"
                    v-model="mountPoint.nmea"
                  ></b-select>
                  <form-error-list-printer
                    :error-list="getMountPointErrors(index, 'nmea')"
                  />
                  <div class="mt-3">{{ $t("mountPoint.solution") }}</div>
                  <b-select
                    class="fz-14"
                    size="sm"
                    :disabled="mountPoint.disabled"
                    :options="solutionOptions"
                    v-model="mountPoint.solution"
                  ></b-select>
                  <form-error-list-printer
                    :error-list="getMountPointErrors(index, 'solution')"
                  />
                  <div class="mt-3">{{ $t("mountPoint.generator") }}</div>
                  <b-input
                    size="sm"
                    v-model="mountPoint.generator"
                    :disabled="mountPoint.disabled"
                  />
                  <form-error-list-printer
                    :error-list="getMountPointErrors(index, 'generator')"
                  />
                  <div class="mt-3">{{ $t("mountPoint.comprEncryp") }}</div>
                  <b-input
                    disabled
                    size="sm"
                    v-model="mountPoint.compr_encryp"
                  />
                  <form-error-list-printer
                    :error-list="getMountPointErrors(index, 'compr_encryp')"
                  />
                  <div class="mt-3">{{ $t("mountPoint.authentication") }}</div>
                  <b-input
                    size="sm"
                    v-model="mountPoint.authentication"
                    disabled
                  />
                  <form-error-list-printer
                    :error-list="getMountPointErrors(index, 'authentication')"
                  />
                  <div class="mt-3">{{ $t("mountPoint.fee") }}</div>
                  <b-select
                    class="fz-14"
                    size="sm"
                    :disabled="mountPoint.disabled"
                    :options="feeOptions"
                    v-model="mountPoint.fee"
                  ></b-select>
                  <form-error-list-printer
                    :error-list="getMountPointErrors(index, 'fee')"
                  />
                  <div class="mt-3">{{ $t("mountPoint.bitrate") }}</div>
                  <b-input
                    type="number"
                    step="1"
                    size="sm"
                    v-model="mountPoint.bitrate"
                    :disabled="mountPoint.disabled"
                  />
                  <form-error-list-printer
                    :error-list="getMountPointErrors(index, 'bitrate')"
                  />
                  <div class="mt-3">{{ $t("mountPoint.misc") }}</div>
                  <b-input
                    size="sm"
                    v-model="mountPoint.misc"
                    :disabled="mountPoint.disabled"
                  />
                  <form-error-list-printer
                    :error-list="getMountPointErrors(index, 'misc')"
                  />
                  <div class="d-flex">
                    <b-btn
                      v-if="!mountPoint.disabled && role === 'admin'"
                      size="sm"
                      @click="saveMountPoint(mountPoint, index)"
                      variant="primary"
                      class="mt-3 ml-auto"
                      >{{ $t("index.save") }}</b-btn
                    >
                  </div>
                </b-card-body>
              </b-tab>
            </b-tabs>
          </b-collapse>
        </b-card>
      </div>
      <b-btn
        v-if="role === 'admin'"
        @click="addMountPoint"
        variant="primary"
        class="mt-3 mb-3"
        >{{ $t("mountPoint.addMountPoint") }}</b-btn
      >
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import FormErrorListPrinter from "@/components/form/FormErrorListPrinter.vue";
import { namespace } from "vuex-class";
import StoreModule from "@/store/StoreModule";

import { BaseStationStoreModule } from "@/modules/admin/base-stations/store/BaseStationStore";
const authStore = namespace("AuthStoreModule");

import { CasterStoreModule } from "@/modules/admin/casters/store/CasterStore";

const casterStoreModule = namespace("CasterStoreModule");
const baseStationStore = namespace("BaseStationStoreModule");
StoreModule.registerMany({
  BaseStationStoreModule,
  CasterStoreModule,
});

@Component({
  components: {
    FormErrorListPrinter,
  },
})
export default class MountPoints extends Vue {
  public mountPoints: any = [];
  public mountPointErrors: any = {};
  public ntripVersions = [
    { text: "1", value: "1" },
    { text: "2", value: "2" },
    { text: this.$t("mountPoint.universal"), value: "universal" },
  ];
  public carrierOptions = [
    { text: this.$t("mountPoint.carriesOptions.0"), value: 0 },
    { text: this.$t("mountPoint.carriesOptions.1"), value: 1 },
    { text: this.$t("mountPoint.carriesOptions.2"), value: 2 },
  ];
  public nmeaOptions = [
    {
      text: this.$t("mountPoint.nmeaOptions.0"),
      value: 0,
    },
    {
      text: this.$t("mountPoint.nmeaOptions.1"),
      value: 1,
    },
  ];
  public solutionOptions = [
    { text: this.$t("mountPoint.solutionOptions.0"), value: 0 },
    { text: this.$t("mountPoint.solutionOptions.1"), value: 1 },
  ];
  public feeOptions = [
    { text: this.$t("mountPoint.feeOptions.0"), value: "N" },
    { text: this.$t("mountPoint.feeOptions.1"), value: "Y" },
  ];

  public mountPointDefaultParams = {
    disabled: false,
    isShow: true,
    name: null,
    user_name: null,
    password: null,
    ntrip_version: "1",
    is_encrypted: false,
    //description fields
    mountpoint: null,
    identifier: null,
    format: null,
    format_details: null,
    carrier: null,
    nav_system: null,
    network: null,
    country: null,
    latitude: null,
    longitude: null,
    nmea: null,
    solution: null,
    generator: null,
    compr_encryp: null,
    authentication: null,
    fee: null,
    bitrate: null,
    misc: null,
  };

  @authStore.Getter("getRole")
  public role!: string;

  @casterStoreModule.Getter("getCountries")
  public getCountries!: any[];

  @baseStationStore.Action("deleteMountPoint")
  deleteMountPointAction!: (payload: any) => Promise<any>;

  @baseStationStore.Action("createMountPoint")
  createMountPointAction!: (receiver: any) => Promise<any>;

  @baseStationStore.Action("updateMountPoint")
  updateMountPointAction!: (antenna: any) => Promise<any>;

  @baseStationStore.Action("getMountPoints")
  getMountPointsAction!: (antenna: any) => Promise<any>;

  @casterStoreModule.Action("getCountries")
  getCountriesAction!: () => Promise<any>;

  public getMountPointErrors(index: number, name: string) {
    return this.mountPointErrors[index]
      ? this.mountPointErrors[index][name]
      : [];
  }

  async removeMountPoint(mountPoint: any) {
    this.$bvModal
      .msgBoxConfirm(this.$t("mountPoint.deleteMountPoint") as string, {
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
            if (mountPoint.id) {
              await this.deleteMountPointAction({
                id: mountPoint.id,
                baseStationId: this.$route.params.baseStationId,
              });
            }
            this.mountPoints.splice(this.mountPoints.indexOf(mountPoint), 1);
          } finally {
            loader.hide();
          }
        }
      });
  }

  public async saveMountPoint(mountPoint: any, index: number) {
    let loader = this.$loading.show();
    try {
      this.$set(this.mountPointErrors, index, {});
      mountPoint.baseStationId = this.$route.params.baseStationId;
      if (mountPoint.id) {
        await this.updateMountPointAction(mountPoint);
      } else {
        let { data } = await this.createMountPointAction(mountPoint);
        mountPoint.id = data.data.id;
        mountPoint.disabled = true;
      }
      this.$toast.success(this.$t("mountPoint.savedSuccessfully") as string);
    } catch (e) {
      this.$toast.error(this.$t("mountPoint.error") as string);
      this.$set(this.mountPointErrors, index, e.response.data.errors);
    } finally {
      loader.hide();
    }
  }

  public async addMountPoint() {
    this.mountPoints.push(Object.assign({}, this.mountPointDefaultParams));
  }

  mounted() {
    this.getMountPointsAction(this.$route.params.baseStationId).then(
      ({ data }) => {
        this.mountPoints = data.list || [];
      }
    );
    this.getCountriesAction();
  }
}
</script>

<style lang="scss">
.mount-point-card-wrapper {
  max-width: 800px;
}
</style>
