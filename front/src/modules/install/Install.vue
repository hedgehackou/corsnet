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
          <div class="d-flex langs">
            <Languages />
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
          <div class="d-flex langs">
            <Languages />
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
                      type="password"
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
                    <input
                      type="password"
                      v-model="smtpParams.login"
                      class="form-control"
                    />
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

  public databaseParams = { ...this.databaseDefaultParams };
  public databaseParamsErrors = { ...this.databaseParams };

  public smtpParams = { ...this.smtpDefaultParams };
  public smtpParamsErrors = { ...this.smtpDefaultParams };

  public appElement: HTMLElement | null = null;
  public currentStep = 2; //this.FIRST_STEP

  @installStore.Action("connectToDatabase")
  connectToDatabase!: (payload: any) => Promise<any>;

  @installStore.Action("setupSmtp")
  setupSmtp!: (payload: any) => Promise<any>;

  public async nextStep() {
    let loader = this.$loading.show();
    this.databaseParamsErrors = { ...this.databaseDefaultParams };
    try {
      switch (this.currentStep) {
        case this.FIRST_STEP:
          let {
            data: { status },
          } = await this.connectToDatabase(this.databaseParams);
          if (status) {
            this.$toast.success(
              this.$t("install.successDatabaseConnection") as string
            );
          } else {
            this.$toast.error(
              this.$t("install.errorDatabaseConnection") as string
            );
          }
          return;
        case this.SECOND_STEP:
          return;
        case this.THIRD_STEP:
          return;
      }
      this.currentStep += 1;
    } catch (errors) {
      this.$toast.error(this.$t("install.errorDatabaseConnection") as string);
      this.databaseParamsErrors = errors.response.data.errors;
    } finally {
      loader.hide();
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
.install {
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
}
</style>
