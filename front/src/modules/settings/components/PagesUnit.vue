<template>
  <section class="content">
    <b-modal
      v-model="showReorderModal"
      centered
      :title="$t('settings.reorderPages')"
      :cancel-title="$t('index.cancel')"
      @ok="reorderBlocks"
    >
      <draggable class="d-flex flex-column" group="items" v-model="pagesClone">
        <b-btn
          variant="info"
          class="mt-2"
          :key="index"
          v-for="(page, index) in pagesClone"
        >
          <div class="d-flex align-items-center">
            <div class="mr-auto">{{ page.title }}</div>
            <div class="ml-auto fa fa-arrows-alt ml-1"></div>
          </div>
        </b-btn>
      </draggable>
    </b-modal>
    <div class="container-fluid overflow-hidden">
      <ChooseBlockModal
        @blockSelected="blockSelected"
        :showModal.sync="showBlockModal"
      />
      <b-tabs
        class="mt-4"
        content-class="mt-3 page-card-wrapper"
        nav-class="align-items-center"
      >
        <b-tab v-for="(page, index) in pages" :key="index" :title="null">
          <template #title>
            <div class="d-flex align-items-center">
              <div>{{ page.title }}</div>
              <b-btn
                v-if="page.is_deletable"
                @click.prevent.stop="removePage(page)"
                class="ml-2"
                variant="danger"
                size="sm"
              >
                <i class="fa fa-trash" />
              </b-btn>
            </div>
          </template>
          <div class="mt-2">{{ $t("settings.pageName") }}</div>
          <b-input class="mt-2" v-model="page.title" />
          <div class="mt-2">{{ $t("settings.slug") }}</div>
          <b-input
            :disabled="!page.is_deletable"
            class="mt-2"
            v-model="page.slug"
          />
          <draggable
            v-model="page.blocks"
            group="blocks"
            draggable=".block-item"
          >
            <template #header v-if="!page.is_deletable">
              <b-card no-body class="mb-1 mt-4">
                <b-card-header header-tag="header" class="p-1" role="tab">
                  <b-button
                    @click.prevent="headerBlock.is_show = !headerBlock.is_show"
                    block
                    :variant="'info'"
                    class="d-flex align-items-center"
                  >
                    <div class="d-flex align-items-center">
                      <div class="fa fa-minus" v-if="headerBlock.is_show"></div>
                      <div class="fa fa-plus" v-else></div>
                      <div class="ml-2">
                        {{ $t(`blocks.header`) }}
                      </div>
                    </div>
                  </b-button>
                </b-card-header>
                <b-collapse v-model="headerBlock.is_show">
                  <b-card-body>
                    <div>
                      <div class="mt-2">{{ $t("blocks.title") }}</div>
                      <b-input v-model="headerBlock.title" />

                      <div class="mt-2">{{ $t("blocks.logo") }}</div>
                      <b-img
                        width="100"
                        v-if="headerBlock.logo"
                        thumbnail
                        :src="headerBlock.logo"
                      ></b-img>
                      <b-form-file
                        @change="fileChanged($event, headerBlock, 'logo')"
                        accept=".jpg, .png, .jpeg"
                        placeholder=""
                        drop-placeholder=""
                      ></b-form-file>
                    </div>
                  </b-card-body>
                </b-collapse>
              </b-card>
            </template>
            <template v-else #header>
              <b-card no-body class="mb-1 mt-4">
                <b-card-header header-tag="header" class="p-1" role="tab">
                  <b-button
                    disabled
                    block
                    :variant="'secondary'"
                    class="d-flex align-items-center"
                  >
                    <div class="d-flex align-items-center">
                      <div class="fa fa-plus"></div>
                      <div class="ml-2">
                        {{ $t(`blocks.header`) }}
                      </div>
                    </div>
                  </b-button>
                </b-card-header>
              </b-card>
            </template>
            <div
              class="block-item"
              :key="ind"
              v-for="(block, ind) in page.blocks"
            >
              <b-card no-body class="mb-1 mt-4">
                <b-card-header header-tag="header" class="p-1" role="tab">
                  <b-button
                    @click.prevent="block.is_show = !block.is_show"
                    block
                    :variant="'info'"
                    class="d-flex align-items-center"
                  >
                    <div class="d-flex align-items-center">
                      <div class="fa fa-minus" v-if="block.is_show"></div>
                      <div class="fa fa-plus" v-else></div>
                      <div class="ml-2">
                        {{ $t(`blocks.${camelize(block.type)}`) }}
                      </div>
                    </div>
                    <b-btn
                      @click.prevent.stop="removeBlock(page, block, ind)"
                      :class="'ml-auto'"
                      size="sm"
                      variant="danger"
                      ><i class="fa fa-trash"></i
                    ></b-btn>
                  </b-button>
                </b-card-header>
                <b-collapse v-model="block.is_show">
                  <b-card-body>
                    <div v-if="block.type === GOOGLE_MAP_BLOCK">
                      <div class="mt-2">{{ $t("blocks.title") }}</div>
                      <b-input v-model="block.title" />
                      <div class="mt-2">{{ $t("blocks.text") }}</div>
                      <b-input v-model="block.text" />
                      <div class="mt-2">{{ $t("blocks.longitude") }}</div>
                      <b-input v-model="block.longitude" />
                      <div class="mt-2">{{ $t("blocks.latitude") }}</div>
                      <b-input v-model="block.latitude" />
                      <div class="mt-2">{{ $t("blocks.zoom") }}</div>
                      <b-input type="number" v-model="block.zoom" />
                    </div>
                    <div v-if="block.type === TEXT_BLOCK">
                      <div>{{ $t("blocks.title") }}</div>
                      <b-input size="sm" v-model="block.title" />
                      <markdown-editor v-model="block.text" class="mt-4" />
                    </div>
                  </b-card-body>
                </b-collapse>
              </b-card>
            </div>
            <template #footer v-if="!page.is_deletable">
              <b-card no-body class="mb-1 mt-4">
                <b-card-header header-tag="header" class="p-1" role="tab">
                  <b-button
                    @click.prevent="footerBlock.is_show = !footerBlock.is_show"
                    block
                    :variant="'info'"
                    class="d-flex align-items-center"
                  >
                    <div class="d-flex align-items-center">
                      <div class="fa fa-minus" v-if="footerBlock.is_show"></div>
                      <div class="fa fa-plus" v-else></div>
                      <div class="ml-2">
                        {{ $t(`blocks.footer`) }}
                      </div>
                    </div>
                  </b-button>
                </b-card-header>
                <b-collapse v-model="footerBlock.is_show">
                  <b-card-body>
                    <div>
                      <div class="mt-2">{{ $t("blocks.address") }}</div>
                      <b-input v-model="footerBlock.address" />
                      <div class="mt-2">{{ $t("blocks.phone") }}</div>
                      <b-input v-model="footerBlock.phone" />
                      <div class="mt-2">{{ $t("blocks.email") }}</div>
                      <b-input v-model="footerBlock.email" />
                    </div>
                  </b-card-body>
                </b-collapse>
              </b-card>
            </template>
            <template v-else #footer>
              <b-card no-body class="mb-1 mt-4">
                <b-card-header header-tag="header" class="p-1" role="tab">
                  <b-button
                    disabled
                    block
                    :variant="'secondary'"
                    class="d-flex align-items-center"
                  >
                    <div class="d-flex align-items-center">
                      <div class="fa fa-plus"></div>
                      <div class="ml-2">
                        {{ $t(`blocks.footer`) }}
                      </div>
                    </div>
                  </b-button>
                </b-card-header>
              </b-card>
            </template>
          </draggable>
          <div class="d-flex mb-3">
            <b-btn
              size="sm"
              @click="openBlockModal(index)"
              variant="info"
              class="mt-3"
              >{{ $t("settings.addBlock") }}</b-btn
            >
            <b-btn
              size="sm"
              @click="savePages()"
              variant="primary"
              class="mt-3 ml-3"
              >{{ $t("index.save") }}</b-btn
            >
          </div>
        </b-tab>
        <template #tabs-start>
          <b-btn @click="openReorderModal" variant="primary" class="mr-2">
            <div class="fas fa-sort"></div>
          </b-btn>
        </template>
        <template #tabs-end>
          <b-nav-item role="presentation" @click.prevent="addPage" href="#">
            <i class="fa fa-plus" />
          </b-nav-item>
        </template>
      </b-tabs>
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
import {
  FOOTER_BLOCK,
  GOOGLE_MAP_BLOCK,
  HEADER_BLOCK,
  TEXT_BLOCK,
} from "@/modules/settings/modals/blocks";

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
  public showBlockModal = false;
  public pages: any = [];
  public pagesClone: any = [];
  public currentPageIndex: number = 0;
  public showReorderModal = false;
  public headerBlock = {};
  public footerBlock = {};

  private HEADER_BLOCK = HEADER_BLOCK;
  private FOOTER_BLOCK = FOOTER_BLOCK;
  private GOOGLE_MAP_BLOCK = GOOGLE_MAP_BLOCK;
  private TEXT_BLOCK = TEXT_BLOCK;

  public pageDefaultParams = {
    id: null,
    title: this.$t("settings.pageName"),
    description: null,
    slug: null,
    sort: null,
    is_deletable: true,
    blocks: [],
    is_show: true,
  };

  @settingsStore.Action("deleteBlock")
  deleteBlockAction!: (payload: any) => Promise<any>;

  @settingsStore.Action("deletePage")
  deletePageAction!: (payload: any) => Promise<any>;

  @settingsStore.Action("savePages")
  savePagesAction!: (payload: any) => Promise<any>;

  @settingsStore.Action("getPages")
  getPagesAction!: () => Promise<any>;

  fileChanged(element: any, obj: any, key: string) {
    const [file] = element.target.files;
    const reader = new FileReader();
    reader.onloadend = function () {
      obj[key] = reader.result;
    };
    reader.readAsDataURL(file);
  }

  public reorderBlocks() {
    this.pages = JSON.parse(JSON.stringify(this.pagesClone));
  }

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

  public async openBlockModal(pageIndex: number) {
    this.currentPageIndex = pageIndex;
    this.showBlockModal = true;
  }

  public camelize(s: string) {
    return s.replace(/-./g, (x: string) => x[1].toUpperCase());
  }

  public async removeBlock(page: any, block: any, blockIndex: number) {
    this.$bvModal
      .msgBoxConfirm(this.$t("blocks.deleteBlock") as string, {
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
            if (block.id) {
              await this.deleteBlockAction({
                id: block.id,
                baseStationId: this.$route.params.baseStationId,
              });
            }
            page.blocks.splice(blockIndex, 1);
          } finally {
            loader.hide();
          }
        }
      });
  }

  public blockSelected({ title, type }: { title: string; type: string }) {
    this.pages[this.currentPageIndex].blocks.push({
      type,
      title,
      is_deletable: true,
    });
  }

  public async savePages() {
    let loader = this.$loading.show();
    try {
      let pages: any[] = JSON.parse(JSON.stringify(this.pages));
      pages.forEach((page) => {
        if (page.slug === "") {
          page.blocks.unshift(Object.assign({}, this.headerBlock));
          page.blocks.push(Object.assign({}, this.footerBlock));
        }
      });
      await this.savePagesAction(pages);
      this.$toast.success(this.$t("settings.pagesSavedSuccessfully") as string);
    } catch (e) {
      this.$toast.error(this.$t("settings.savePageError") as string);
    } finally {
      loader.hide();
    }
  }

  public openReorderModal() {
    this.showReorderModal = true;
    this.pagesClone = JSON.parse(JSON.stringify(this.pages));
  }

  public async addPage() {
    this.pages.push(Object.assign({}, this.pageDefaultParams));
  }

  async mounted() {
    let loader = this.$loading.show();
    try {
      const { list } = await this.getPagesAction();
      this.pages = list.map((page: any) => {
        if (page.slug === "") {
          page.blocks = page.blocks.filter((block: any) => {
            if (block.type === HEADER_BLOCK) {
              this.headerBlock = block;
              return false;
            }
            if (block.type === FOOTER_BLOCK) {
              this.footerBlock = block;
              return false;
            }
            return true;
          });
        }
        return page;
      });
    } finally {
      loader.hide();
    }
  }
}
</script>

<style lang="scss">
.page-card-wrapper {
  max-width: 1000px;
  header {
    cursor: move;
    & > button {
      cursor: move;
    }
    &.card-header .btn-block {
      min-height: 45px;
    }
  }
}
.drag-n-drop-icon {
  position: absolute;
  display: none;
  top: 5px;
  right: 5px;
}
</style>
