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
            <b-card-body>
              <div>{{ $t("mountPoint.name") }}</div>
              <b-input
                size="sm"
                v-model="mountPoint.name"
                :disabled="mountPoint.disabled"
              />
              <form-error-list-printer
                :error-list="
                  mountPointErrors[index] ? mountPointErrors[index].name : []
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

const baseStationStore = namespace("BaseStationStoreModule");
StoreModule.registerMany({
  BaseStationStoreModule,
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

  public mountPointDefaultParams = {
    disabled: false,
    isShow: true,
    name: null,
    user_name: null,
    password: null,
    ntrip_version: "1",
    is_encrypted: false,
  };

  @authStore.Getter("getRole")
  public role!: string;

  @baseStationStore.Action("deleteMountPoint")
  deleteMountPointAction!: (payload: any) => Promise<any>;

  @baseStationStore.Action("createMountPoint")
  createMountPointAction!: (receiver: any) => Promise<any>;

  @baseStationStore.Action("updateMountPoint")
  updateMountPointAction!: (antenna: any) => Promise<any>;

  @baseStationStore.Action("getMountPoints")
  getMountPointsAction!: (antenna: any) => Promise<any>;

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
  }
}
</script>

<style lang="scss">
.mount-point-card-wrapper {
  max-width: 800px;
}
</style>
