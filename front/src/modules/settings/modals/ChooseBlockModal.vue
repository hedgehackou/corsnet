<template>
  <b-modal
    v-model="show"
    centered
    @shown="shown"
    :cancel-title="$t('settings.cancel')"
    :title="
      currentStep === FIRST_STEP
        ? $t('settings.chooseBlock')
        : $t('settings.chooseBlockTitle')
    "
  >
    <div class="d-flex flex-column" v-if="currentStep === FIRST_STEP">
      <b-btn
        :key="index"
        v-for="(block, index) in blocks"
        class="mt-2"
        :variant="chosenBlock === block.type ? 'primary' : 'secondary'"
        @click="chosenBlock = block.type"
        >{{ $t(`blocks.${block.title}`) }}</b-btn
      >
    </div>
    <div v-else class="d-flex flex-column">
      <b-input v-model="blockTitle"></b-input>
    </div>
    <template slot="modal-footer">
      <b-btn
        class="d-flex align-items-center"
        :disabled="currentStep === FIRST_STEP"
        @click="prevStep"
        size="sm"
        variant="danger"
      >
        <i class="fa fa-arrow-left mr-1" /> {{ $t("index.prev") }}
      </b-btn>
      <b-btn
        v-if="currentStep === FIRST_STEP"
        class="d-flex align-items-center"
        @click="nextStep"
        :disabled="chosenBlock === null"
        size="sm"
        variant="success"
      >
        {{ $t("index.next") }}
        <i class="fa fa-arrow-right ml-1" />
      </b-btn>
      <b-btn
        v-else
        class="d-flex align-items-center"
        @click="selectBlock"
        :disabled="!blockTitle"
        size="sm"
        variant="success"
      >
        {{ $t("index.save") }}
        <i class="fa fa-save ml-1" />
      </b-btn>
    </template>
  </b-modal>
</template>

<script lang="ts">
import { Component, PropSync, Vue } from "vue-property-decorator";
import FormErrorListPrinter from "@/components/form/FormErrorListPrinter.vue";
import { BLOCKS } from "@/modules/settings/modals/blocks";

@Component({
  components: {
    FormErrorListPrinter,
  },
})
export default class ChooseBlockModal extends Vue {
  @PropSync("showModal", { type: Boolean, default: true }) show!: boolean;
  public FIRST_STEP = 1;
  public currentStep = 1;
  public chosenBlock: string | null = null;
  public blocks = BLOCKS;
  public blockTitle: string = "";

  public nextStep() {
    this.currentStep += 1;
  }

  public selectBlock() {
    this.$emit("blockSelected", {
      title: this.blockTitle,
      type: this.chosenBlock,
    });
    this.show = false;
  }

  public prevStep() {
    if (this.currentStep === this.FIRST_STEP) {
      return;
    }
    this.currentStep -= 1;
  }

  public shown() {
    this.currentStep = this.FIRST_STEP;
    this.chosenBlock = null;
    this.blockTitle = "";
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
