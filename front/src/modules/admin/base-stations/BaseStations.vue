<template>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <b-button
            v-if="role === 'admin'"
            @click="createBaseStation"
            class="mt-4"
            variant="primary"
            >{{ $t("baseStations.create") }}</b-button
          >
        </div>
        <div class="col-12">
          <b-table
            class="mt-4 invite-table"
            responsive
            hover
            show-empty
            :items="getBaseStationList"
            :fields="getBaseStationTableFields"
          >
            <template #empty="">
              <h4>{{ $t("baseStations.emptyTable") }}</h4>
            </template>
            <template #head(name)="">
              {{ $t("baseStations.name") }}
            </template>
            <template #head(latitude)="">
              {{ $t("baseStations.latitude") }}
            </template>
            <template #head(longitude)="">
              {{ $t("baseStations.longitude") }}
            </template>
            <template #head(created_at)="">
              {{ $t("baseStations.createdAt") }}
            </template>
            <template #head(actions)="">
              {{ $t("baseStations.actions") }}
            </template>
            <template #cell(actions)="{ item }">
              <b-btn
                class="mr-2"
                variant="primary"
                @click="openViewPage(item.id)"
              >
                <div class="fa fa-eye"></div>
              </b-btn>
              <b-btn
                v-if="role === 'admin'"
                class="mr-2"
                variant="primary"
                @click="editAction(item.id)"
              >
                <div class="fa fa-pencil-alt"></div>
              </b-btn>
              <b-btn
                v-if="role === 'admin'"
                class="mr-2"
                variant="danger"
                @click="openDeleteModal(item.id)"
              >
                <div class="fa fa-trash"></div>
              </b-btn>
            </template>
          </b-table>
          <b-pagination
            class="ml-auto mt-1 mb-0"
            @change="changePage"
            :value="getCurrentPage"
            :total-rows="getTotal"
            :per-page="getPerPage"
          ></b-pagination>
        </div>
      </div>
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
export default class BaseStations extends Vue {
  @authStore.Getter("getRole")
  public role!: string;

  @baseStationStore.Getter("getBaseStationList")
  public getBaseStationList!: any[];

  @baseStationStore.Getter("getTotal")
  public getTotal!: any[];

  @baseStationStore.Getter("getPerPage")
  public getPerPage!: any[];

  @baseStationStore.Getter("getCurrentPage")
  public getCurrentPage!: any[];

  @baseStationStore.Action("getBaseStationList")
  getBaseStationListAction!: (payload: any) => Promise<any>;

  @baseStationStore.Action("deleteBaseStation")
  deleteBaseStationAction!: (payload: any) => Promise<any>;

  public get getBaseStationTableFields() {
    return [
      { key: "name" },
      { key: "longitude" },
      { key: "latitude" },
      { key: "created_at" },
      { key: "actions" },
    ];
  }

  public createBaseStation() {
    this.$router.push({ name: `${this.role}-create-base-station` });
  }

  public openViewPage(baseStationId: string) {
    this.$router.push({
      name: `${this.role}-view-base-station`,
      params: { baseStationId },
    });
  }

  public openReceiversPage(baseStationId: string) {
    this.$router.push({
      name: `${this.role}-base-station-receivers`,
      params: { baseStationId },
    });
  }

  public editAction(baseStationId: string) {
    this.$router.push({
      name: `${this.role}-edit-base-station`,
      params: { baseStationId },
    });
  }

  public openDeleteModal(id: number) {
    this.$bvModal
      .msgBoxConfirm(this.$t("baseStations.deleteBaseStation") as string, {
        title: this.$t("baseStations.confirm") as string,
        size: "sm",
        buttonSize: "sm",
        okVariant: "danger",
        okTitle: this.$t("baseStations.yes") as string,
        cancelTitle: this.$t("baseStations.no") as string,
        footerClass: "p-2",
        hideHeaderClose: false,
        centered: true,
      })
      .then(async (value) => {
        if (value) {
          let loader = this.$loading.show();
          try {
            await this.deleteBaseStationAction(id);
            await this.getBaseStationListAction({});
          } finally {
            loader.hide();
          }
        }
      });
  }

  public changePage(page = 1) {
    this.getBaseStationListAction({ page });
  }

  async mounted() {
    this.getBaseStationListAction({});
  }
}
</script>

<style scoped>
.invite-table {
  background-color: #fff;
}
</style>
