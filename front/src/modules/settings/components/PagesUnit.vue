<template>
  <section class="content">
    <div class="container-fluid overflow-hidden">
      <ChooseBlockModal :show-modal="showBlockModal" />
      <div class="page-card-wrapper">
        <draggable v-model="pages" group="cards">
          <b-card
            v-for="(page, index) in pages"
            :key="index"
            no-body
            class="mb-1 mt-4"
          >
            <b-card-header header-tag="header" class="p-1" role="tab">
              <b-button
                @click.prevent="page.isShow = !page.isShow"
                block
                variant="info"
                class="d-flex align-items-center"
              >
                <div class="d-flex align-items-center">
                  <div class="fa fa-minus" v-if="page.isShow"></div>
                  <div class="fa fa-plus" v-else></div>
                </div>
                <b-btn
                  v-if="page.id && role === 'admin'"
                  @click.prevent.stop="page.disabled = !page.disabled"
                  class="ml-auto"
                  size="sm"
                  variant="primary"
                  ><i class="fa fa-pencil-alt"></i
                ></b-btn>
                <b-btn
                  @click.prevent.stop="removePage(page)"
                  :class="page.id ? 'ml-2' : 'ml-auto'"
                  size="sm"
                  variant="danger"
                  ><i class="fa fa-trash"></i
                ></b-btn>
              </b-button>
            </b-card-header>
            <b-collapse v-model="page.isShow">
              <b-card-body>
                <div>{{ $t("page.model") }}</div>
                <b-input
                  size="sm"
                  v-model="page.model"
                  :disabled="page.disabled"
                />
                <form-error-list-printer
                  :error-list="pageErrors[index] ? pageErrors[index].model : []"
                />
                <div class="mt-3">{{ $t("page.serialNumber") }}</div>
                <b-input size="sm" class="" v-model="page.serial_number" />
                <form-error-list-printer
                  :error-list="
                    pageErrors[index] ? pageErrors[index].serial_number : []
                  "
                />
                <div class="mt-3">{{ $t("page.upEccentricity") }}</div>
                <b-input
                  type="number"
                  size="sm"
                  class=""
                  v-model="page.up_eccentricity"
                />
                <form-error-list-printer
                  :error-list="
                    pageErrors[index] ? pageErrors[index].up_eccentricity : []
                  "
                />
                <div class="mt-3">{{ $t("page.northEccentricity") }}</div>
                <b-input
                  type="number"
                  size="sm"
                  class=""
                  v-model="page.north_eccentricity"
                />
                <form-error-list-printer
                  :error-list="
                    pageErrors[index]
                      ? pageErrors[index].north_eccentricity
                      : []
                  "
                />
                <div class="mt-3">{{ $t("page.eastEccentricity") }}</div>
                <b-input
                  type="number"
                  size="sm"
                  class=""
                  v-model="page.east_eccentricity"
                />
                <form-error-list-printer
                  :error-list="
                    pageErrors[index] ? pageErrors[index].east_eccentricity : []
                  "
                />
                <div class="mt-3">{{ $t("page.alignment") }}</div>
                <b-input
                  type="number"
                  size="sm"
                  class=""
                  v-model="page.alignment"
                />
                <form-error-list-printer
                  :error-list="
                    pageErrors[index] ? pageErrors[index].alignment : []
                  "
                />
                <div class="d-flex">
                  <b-btn
                    size="sm"
                    @click="openBlockModal(page, index)"
                    variant="primary"
                    class="mt-3 mr-auto"
                    >{{ $t("settings.addBlock") }}</b-btn
                  >
                  <b-btn
                    size="sm"
                    @click="savePage(page, index)"
                    variant="primary"
                    class="mt-3 ml-auto"
                    >{{ $t("index.save") }}</b-btn
                  >
                </div>
              </b-card-body>
            </b-collapse>
          </b-card>
        </draggable>
      </div>
      <b-btn @click="addPage" variant="primary" class="mt-3 mb-3">{{
        $t("settings.addPage")
      }}</b-btn>
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import FormErrorListPrinter from "@/components/form/FormErrorListPrinter.vue";
import { namespace } from "vuex-class";
import StoreModule from "@/store/StoreModule";
import Draggable from "vuedraggable";
import { SettingsStoreModule } from "@/modules/settings/store/SettingsStore";
import ChooseBlockModal from "@/modules/settings/modals/ChooseBlockModal.vue";

const settingsStore = namespace("SettingsStoreModule");
StoreModule.registerMany({
  SettingsStoreModule,
});

@Component({
  components: {
    FormErrorListPrinter,
    Draggable,
    ChooseBlockModal,
  },
})
export default class PagesUnit extends Vue {
  public showBlockModal = true;
  public pages: any = [];

  public pageDefaultParams = {
    id: null,
    title: null,
    description: null,
    slug: null,
    sort: null,
    is_deletable: null,
  };
  public pageErrors: any = {};

  @settingsStore.Action("deletePage")
  deletePageAction!: (payload: any) => Promise<any>;

  @settingsStore.Action("createPage")
  createPageAction!: (payload: any) => Promise<any>;

  @settingsStore.Action("updatePage")
  updatePageAction!: (payload: any) => Promise<any>;

  @settingsStore.Action("getPages")
  getPagesAction!: () => Promise<any>;

  async removePage(page: any) {
    this.$bvModal
      .msgBoxConfirm(this.$t("settings.deletePage") as string, {
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
            if (page.id) {
              await this.deletePageAction(page.id);
            }
            this.pages.splice(this.pages.indexOf(page), 1);
          } finally {
            loader.hide();
          }
        }
      });
  }

  public async openBlockModal() {
    this.showBlockModal = true;
  }

  public async savePage(page: any, index: number) {
    let loader = this.$loading.show();
    try {
      this.$set(this.pageErrors, index, {});
      page.baseStationId = this.$route.params.baseStationId;
      if (page.id) {
        await this.updatePageAction(page);
      } else {
        let { data } = await this.createPageAction(page);
        page.id = data.data.id;
      }
      this.$toast.success(this.$t("settings.pageSavedSuccessfully") as string);
    } catch (e) {
      this.$toast.error(this.$t("settings.pageError") as string);
      this.$set(this.pageErrors, index, e.response.data.errors);
    } finally {
      loader.hide();
    }
  }

  public async addPage() {
    this.pages.push(Object.assign({}, this.pageDefaultParams));
  }

  mounted() {
    // this.getPagesAction().then(({ data }) => {
    //   this.pages = data.list;
    // });
  }
}
</script>

<style lang="scss">
.page-card-wrapper {
  max-width: 800px;
  header {
    cursor: move;
    & > button {
      cursor: move;
    }
  }
}
</style>
