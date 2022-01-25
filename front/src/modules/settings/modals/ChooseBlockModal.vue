<template>
  <b-modal
    :cancel-title="$t('settings.cancel')"
    :title="$t('settings.addBlock')"
  >
    <div>test</div>
  </b-modal>
</template>

<script lang="ts">
import { Component, PropSync, Vue } from "vue-property-decorator";
import FormErrorListPrinter from "@/components/form/FormErrorListPrinter.vue";
import { namespace } from "vuex-class";
import StoreModule from "@/store/StoreModule";
import { SettingsStoreModule } from "@/modules/settings/store/SettingsStore";

const settingsStore = namespace("SettingsStoreModule");
StoreModule.registerMany({
  SettingsStoreModule,
});

@Component({
  components: {
    FormErrorListPrinter,
  },
})
export default class ChooseBlockModal extends Vue {
  @PropSync("showModal", { type: Boolean, default: true }) show!: boolean;
  test = true;

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

  mounted() {
    console.log("showModal: ", this.show);
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
