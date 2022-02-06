<template>
  <div class="main-unit-card-wrapper">
    <b-card-body>
      <div class="mt-3">{{ $t("settings.networkName") }}</div>
      <b-input v-model="settingsParams.network_name" class="" />
      <form-error-list-printer :error-list="settingsErrors.network_name" />

      <div class="mt-3">{{ $t("settings.lang") }}</div>
      <select v-model="settingsParams.lang" class="form-control">
        <option value="ru">RU</option>
        <option value="en">EN</option>
      </select>

      <div class="mt-3">{{ $t("settings.googleApiKey") }}</div>
      <b-input v-model="settingsParams.google_map_key" class="" />
      <form-error-list-printer :error-list="settingsErrors.google_map_key" />
      <div class="d-flex">
        <b-btn @click="updateSettings" variant="primary" class="mt-3 ml-auto">{{
          $t("index.save")
        }}</b-btn>
      </div>
    </b-card-body>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
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
export default class MainUnit extends Vue {
  public settingsDefaultParams = {
    network_name: null,
    lang: null,
    google_map_key: null,
    allow_user_sign_up: null,
  };
  public settingsParams: any = { ...this.settingsDefaultParams };
  public settingsErrors: any = { ...this.settingsDefaultParams };

  @settingsStore.Action("updateSettings")
  updateSettingsAction!: (params: any) => Promise<any>;

  @settingsStore.Action("getSettings")
  getSettingsAction!: () => Promise<any>;

  public async updateSettings() {
    let loader = this.$loading.show();
    this.settingsErrors = { ...this.settingsDefaultParams };
    try {
      await this.updateSettingsAction(this.settingsParams);
      this.$toast.success(this.$t("settings.updatedSuccessfully") as string);
    } catch (e) {
      this.$toast.error(this.$t("settings.error") as string);
      Object.assign(this.settingsErrors, e.response.data.errors);
    } finally {
      loader.hide();
    }
  }

  async mounted() {
    const { data } = await this.getSettingsAction();
    Object.assign(this.settingsParams, data);
  }
}
</script>

<style lang="scss">
.main-unit-card-wrapper {
  max-width: 800px;
}
</style>
