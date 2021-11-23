<template>
  <div class="container install">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-primary" v-if="currentStep === FIRST_STEP">
          <div class="card-header">
            <h3 class="card-title">
              {{ $t("install.setupDatabase") }}
            </h3>
            <div class="ml-auto"></div>
          </div>
          <form>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ $t("install.server") }}</label>
                    <input
                      v-model="databaseParams.host"
                      class="form-control"
                      placeholder="localhost"
                    />
                    <FormErrorListPrinter
                      :error-list="databaseParamsErrors.host"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ $t("install.databaseName") }}</label>
                    <input
                      v-model="databaseParams.database"
                      class="form-control"
                    />
                    <FormErrorListPrinter
                      :error-list="databaseParamsErrors.database"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ $t("install.login") }}</label>
                    <input
                      v-model="databaseParams.username"
                      class="form-control"
                    />
                    <FormErrorListPrinter
                      :error-list="databaseParamsErrors.username"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ $t("install.password") }}</label>
                    <input
                      type="password"
                      v-model="databaseParams.password"
                      class="form-control"
                    />
                    <FormErrorListPrinter
                      :error-list="databaseParamsErrors.password"
                    />
                  </div>
                </div>
              </div>
            </div>

            <div class="card-footer">
              <div class="d-flex">
                <button
                  type="button"
                  @click="nextStep"
                  class="btn btn-success ml-auto"
                >
                  {{ $t("install.next") }}
                </button>
              </div>
            </div>
          </form>
        </div>
        <div class="card card-primary" v-if="currentStep === SECOND_STEP">
          <div class="card-header">
            <h3 class="card-title">
              {{ $t("install.setupSmtp") }}
            </h3>
            <div class="ml-auto"></div>
          </div>
          <form>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ $t("install.host") }}</label>
                    <input
                      placeholder="smtp.mailtrap.io"
                      v-model="smtpParams.host"
                      class="form-control"
                    />
                    <FormErrorListPrinter :error-list="smtpParamsErrors.host" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ $t("install.port") }}</label>
                    <input
                      placeholder="2525"
                      v-model="smtpParams.port"
                      class="form-control"
                    />
                    <FormErrorListPrinter :error-list="smtpParamsErrors.port" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ $t("install.encryption") }}</label>
                    <input
                      placeholder="tls"
                      v-model="smtpParams.encryption"
                      class="form-control"
                    />
                    <FormErrorListPrinter
                      :error-list="smtpParamsErrors.encryption"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ $t("install.login") }}</label>
                    <input v-model="smtpParams.login" class="form-control" />
                    <FormErrorListPrinter
                      :error-list="smtpParamsErrors.login"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ $t("install.password") }}</label>
                    <input
                      type="password"
                      v-model="smtpParams.password"
                      class="form-control"
                    />
                    <FormErrorListPrinter
                      :error-list="smtpParamsErrors.password"
                    />
                  </div>
                </div>
              </div>
            </div>

            <div class="card-footer">
              <div class="d-flex">
                <button
                  type="button"
                  @click="nextStep"
                  class="btn btn-success ml-auto"
                >
                  {{ $t("install.next") }}
                </button>
              </div>
            </div>
          </form>
        </div>
        <div class="card card-primary" v-if="currentStep === THIRD_STEP">
          <div class="card-header">
            <h3 class="card-title">
              {{ $t("install.settings") }}
            </h3>
            <div class="ml-auto"></div>
          </div>
          <form>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ $t("install.networkName") }}</label>
                    <input
                      placeholder=""
                      v-model="settingParams.network_name"
                      class="form-control"
                    />
                    <FormErrorListPrinter
                      :error-list="settingParamsErrors.network_name"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ $t("install.selectLanguage") }}</label>
                    <select v-model="settingParams.lang" class="form-control">
                      <option value="ru">RU</option>
                      <option value="en">EN</option>
                    </select>
                    <FormErrorListPrinter
                      :error-list="settingParamsErrors.lang"
                    />
                  </div>
                </div>
              </div>
            </div>

            <div class="card-footer">
              <div class="d-flex">
                <button
                  type="button"
                  @click="nextStep"
                  class="btn btn-success ml-auto"
                >
                  {{ $t("install.next") }}
                </button>
              </div>
            </div>
          </form>
        </div>
        <div class="card card-primary" v-if="currentStep === FOURTH_STEP">
          <div class="card-header">
            <h3 class="card-title">
              {{ $t("install.adminAccount") }}
            </h3>
            <div class="ml-auto"></div>
          </div>
          <form>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ $t("install.email") }}</label>
                    <input
                      placeholder=""
                      v-model="installationParams.email"
                      class="form-control"
                    />
                    <FormErrorListPrinter
                      :error-list="installationParamsErrors.email"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ $t("install.name") }}</label>
                    <input
                      placeholder=""
                      v-model="installationParams.name"
                      class="form-control"
                    />
                    <FormErrorListPrinter
                      :error-list="installationParamsErrors.name"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ $t("install.password") }}</label>
                    <input
                      type="password"
                      placeholder=""
                      v-model="installationParams.password"
                      class="form-control"
                    />
                    <FormErrorListPrinter
                      :error-list="installationParamsErrors.password"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ $t("install.passwordConfirmation") }}</label>
                    <input
                      type="password"
                      placeholder=""
                      v-model="installationParams.password_confirmation"
                      class="form-control"
                    />
                    <FormErrorListPrinter
                      :error-list="
                        installationParamsErrors.password_confirmation
                      "
                    />
                  </div>
                </div>
              </div>
            </div>

            <div class="card-footer">
              <div class="d-flex">
                <button
                  v-if="currentStep === FOURTH_STEP"
                  type="button"
                  @click="installation"
                  class="btn btn-success ml-auto"
                >
                  {{ $t("install.create") }}
                </button>
                <button
                  v-else
                  type="button"
                  @click="nextStep"
                  class="btn btn-success ml-auto"
                >
                  {{ $t("install.next") }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue } from "vue-property-decorator";
import Languages from "@/components/languages/Languages.vue";
import FormErrorListPrinter from "@/components/form/FormErrorListPrinter.vue";
import StoreModule from "@/store/StoreModule";
import { InstallStoreModule } from "@/modules/install/store/InstallStore";

import Component from "vue-class-component";
import { namespace } from "vuex-class";

StoreModule.registerMany({
  InstallStoreModule,
});

const installStore = namespace("InstallStoreModule");

@Component({
  components: {
    Languages,
    FormErrorListPrinter,
  },
})
export default class Install extends Vue {
  public FIRST_STEP = 1;
  public SECOND_STEP = 2;
  public THIRD_STEP = 3;
  public FOURTH_STEP = 4;

  public databaseDefaultParams = {
    host: null,
    database: null,
    username: null,
    password: null,
  };
  public smtpDefaultParams = {
    host: null,
    login: null,
    password: null,
    port: null,
    encryption: null,
  };
  public settingsDefaultParams = {
    network_name: null,
    lang: null,
  };

  public installationDefaultParams = {
    ...this.settingsDefaultParams,
    email: null,
    name: null,
    password: null,
    password_confirmation: null,
  };

  public databaseParams = { ...this.databaseDefaultParams };
  public databaseParamsErrors = { ...this.databaseParams };

  public smtpParams = { ...this.smtpDefaultParams };
  public smtpParamsErrors = { ...this.smtpDefaultParams };

  public settingParams = { ...this.settingsDefaultParams };
  public settingParamsErrors = { ...this.settingsDefaultParams };

  public installationParams = { ...this.installationDefaultParams };
  public installationParamsErrors = { ...this.installationDefaultParams };

  public appElement: HTMLElement | null = null;
  public currentStep = this.FIRST_STEP;

  @installStore.Action("connectToDatabase")
  connectToDatabaseAction!: (payload: any) => Promise<any>;

  @installStore.Action("setupSmtp")
  setupSmtpAction!: (payload: any) => Promise<any>;

  @installStore.Action("addSettings")
  addSettingsAction!: (payload: any) => Promise<any>;

  @installStore.Action("addAdminParams")
  addAdminParamsAction!: (payload: any) => Promise<any>;

  @installStore.Action("installation")
  installationAction!: (payload: any) => Promise<any>;

  public async nextStep() {
    let loader = this.$loading.show();
    try {
      switch (this.currentStep) {
        case this.FIRST_STEP:
          await this.connectToDatabase();
          break;
        case this.SECOND_STEP:
          await this.setupSmtp();
          break;
        case this.THIRD_STEP:
          await this.addSettings();
          break;
      }
    } finally {
      loader.hide();
    }
  }

  public async installation() {
    this.installationParamsErrors = { ...this.installationDefaultParams };
    try {
      await this.installationAction({
        ...this.installationParams,
        ...this.settingParams,
      });
      this.$toast.success(this.$t("install.installSuccess") as string);
      (this.appElement as HTMLElement).classList.remove("login-page");
      await this.$router.push({
        name: "admin-dashboard",
      });
    } catch (e) {
      this.installationParamsErrors = e.response.data.errors;
    }
  }

  public async addSettings() {
    this.settingParamsErrors = { ...this.settingsDefaultParams };
    try {
      await this.addSettingsAction(this.settingParams);
      this.currentStep += 1;
    } catch (e) {
      this.settingParamsErrors = e.response.data.errors;
    }
  }

  public async setupSmtp() {
    this.smtpParamsErrors = { ...this.smtpDefaultParams };
    try {
      let smtpResponse = await this.setupSmtpAction(this.smtpParams);
      if (smtpResponse.data.status) {
        this.$toast.success(this.$t("install.successSmtpConnection") as string);
        this.currentStep += 1;
      } else {
        this.$toast.error(this.$t("install.errorSmtpConnection") as string);
      }
    } catch (e) {
      this.$toast.error(this.$t("install.errorSmtpConnection") as string);
      this.smtpParamsErrors = e.response.data.errors;
    }
  }

  public async connectToDatabase() {
    this.databaseParamsErrors = { ...this.databaseDefaultParams };
    try {
      let databaseResponse = await this.connectToDatabaseAction(
        this.databaseParams
      );
      if (databaseResponse.data.status) {
        this.$toast.success(
          this.$t("install.successDatabaseConnection") as string
        );
        this.currentStep += 1;
      } else {
        this.$toast.error(this.$t("install.errorDatabaseConnection") as string);
      }
    } catch (e) {
      this.$toast.error(this.$t("install.errorDatabaseConnection") as string);
      this.databaseParamsErrors = e.response.data.errors;
    }
  }

  public mounted() {
    this.appElement = document.getElementById("app") as HTMLElement;
    this.appElement.classList.add("login-page");
  }

  public unmounted(): void {
    (this.appElement as HTMLElement).classList.remove("login-page");
  }
}
</script>

<style lang="scss">
.langs {
  display: flex;
  li {
    margin-left: auto;
    list-style-type: none;
    button {
      border: 1px solid rgba(0, 0, 0, 0.125);
      background: rgba(0, 0, 0, 0.03);
    }
  }
}
</style>
