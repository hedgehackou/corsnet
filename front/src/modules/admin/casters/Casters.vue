<template>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <b-button @click="createCaster" class="mt-4" variant="primary">{{
            $t("caster.create")
          }}</b-button>
        </div>
        <div class="col-12">
          <b-table
            class="mt-4 caster-table"
            responsive
            hover
            show-empty
            :items="getCasterList"
            :fields="getCasterTableFields"
          >
            <template #empty="">
              <h4>{{ $t("caster.emptyTable") }}</h4>
            </template>
            <template #head(name)="">
              {{ $t("caster.name") }}
            </template>
            <template #head(host)="">
              {{ $t("caster.host") }}
            </template>
            <template #head(port)="">
              {{ $t("caster.port") }}
            </template>
            <template #head(latitude)="">
              {{ $t("caster.latitude") }}
            </template>
            <template #head(longitude)="">
              {{ $t("caster.longitude") }}
            </template>
            <template #head(actions)="">
              {{ $t("caster.actions") }}
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
                class="mr-2"
                variant="primary"
                @click="refreshCaster(item.id)"
              >
                <div class="fa fa-sync"></div>
              </b-btn>
              <b-btn
                class="mr-2"
                variant="primary"
                @click="editAction(item.id)"
              >
                <div class="fa fa-pencil-alt"></div>
              </b-btn>
              <b-btn
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
import { CasterStoreModule } from "@/modules/admin/casters/store/CasterStore";

const casterStore = namespace("CasterStoreModule");
StoreModule.registerMany({
  CasterStoreModule,
});

@Component({
  components: {
    FormErrorListPrinter,
  },
})
export default class Casters extends Vue {
  @casterStore.Getter("getCasterList")
  public getCasterList!: any[];

  @casterStore.Getter("getTotal")
  public getTotal!: any[];

  @casterStore.Getter("getPerPage")
  public getPerPage!: any[];

  @casterStore.Getter("getCurrentPage")
  public getCurrentPage!: any[];

  @casterStore.Action("getCasterList")
  getCasterListAction!: (payload: any) => Promise<any>;

  @casterStore.Action("refreshCaster")
  refreshCasterAction!: (casterId: string) => Promise<any>;

  @casterStore.Action("deleteCaster")
  deleteCasterAction!: (payload: any) => Promise<any>;

  public get getCasterTableFields() {
    return [
      { key: "name" },
      { key: "host" },
      { key: "port" },
      { key: "longitude" },
      { key: "latitude" },
      { key: "actions" },
    ];
  }

  public createCaster() {
    this.$router.push({ name: `admin-create-caster` });
  }

  public openViewPage(casterId: string) {
    this.$router.push({
      name: `admin-view-caster`,
      params: { casterId },
    });
  }

  public async refreshCaster(casterId: string) {
    let loader = this.$loading.show();
    try {
      await this.refreshCasterAction(casterId);
      this.$toast.success(this.$t("caster.updatedSuccessfully") as string);
    } catch (e) {
      this.$toast.error(this.$t("caster.updateError") as string);
    } finally {
      loader.hide();
    }
  }

  public editAction(casterId: string) {
    this.$router.push({
      name: `admin-edit-caster`,
      params: { casterId },
    });
  }

  public openDeleteModal(id: number) {
    this.$bvModal
      .msgBoxConfirm(this.$t("caster.confirm") as string, {
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
            await this.deleteCasterAction(id);
            await this.getCasterListAction({});
          } finally {
            loader.hide();
          }
        }
      });
  }

  public changePage(page = 1) {
    this.getCasterListAction({ page });
  }

  async mounted() {
    this.getCasterListAction({});
  }
}
</script>

<style scoped>
.caster-table {
  background-color: #fff;
}
</style>
