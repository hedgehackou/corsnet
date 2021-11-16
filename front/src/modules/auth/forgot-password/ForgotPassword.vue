<template>
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="#" class="h1"><b>Admin</b>LTE</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">
          {{ $t("auth.resetPassword") }}
        </p>
        <form>
          <div class="input-group">
            <input
              v-model="email"
              type="email"
              class="form-control"
              placeholder="Email"
            />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <form-error-list-printer
            class="mb-3"
            :error-list="resetPasswordErrors.email"
          />
          <div class="row">
            <div class="col-12">
              <button
                @click="sendResetLink"
                type="button"
                class="btn btn-primary btn-block"
              >
                {{ $t("auth.send") }}
              </button>
            </div>
            <!-- /.col -->
          </div>
        </form>
        <p class="mt-3 mb-1">
          <router-link :to="{ name: 'login' }">{{
            $t("auth.signIn")
          }}</router-link>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->
</template>

<script lang="ts">
import { Vue } from "vue-property-decorator";
import Component from "vue-class-component";
import Languages from "@/components/languages/Languages.vue";
import FormErrorListPrinter from "@/components/form/FormErrorListPrinter.vue";
import { AuthStoreModule } from "@/modules/auth/store/AuthStore";
import StoreModule from "@/store/StoreModule";
import { namespace } from "vuex-class";

StoreModule.registerMany({
  AuthStoreModule,
});

const authStore = namespace("AuthStoreModule");

@Component({
  components: {
    Languages,
    FormErrorListPrinter,
  },
})
export default class ForgotPassword extends Vue {
  private appElement: HTMLElement | null = null;
  public email: string = "";

  public resetPasswordErrors = { email: null };

  @authStore.Action("sendResetLink")
  sendResetLinkAction!: (payload: any) => Promise<any>;

  public mounted(): void {
    this.appElement = document.getElementById("app") as HTMLElement;
    this.appElement.classList.add("login-page");
  }

  public unmounted(): void {
    this.removeAppClass();
  }

  public removeAppClass() {
    (this.appElement as HTMLElement).classList.remove("login-page");
  }

  public async sendResetLink(): Promise<void> {
    let loader = this.$loading.show();
    this.resetPasswordErrors = { email: null };
    try {
      await this.sendResetLinkAction({ email: this.email });
      this.$toast.success(this.$t("auth.resetPasswordLinkSent") as string);
      this.removeAppClass();
      await this.$router.push({
        name: "login",
      });
    } catch (error: any) {
      this.resetPasswordErrors = error.response.data.errors;
      this.$toast.error(this.$t("auth.resetPasswordError") as string);
    } finally {
      loader.hide();
    }
  }
}
</script>

<style lang="scss">
.login-box {
  position: relative;
  .lang-module {
    display: flex;
    position: absolute;
    right: 0;
    top: 2px;
    z-index: 1000;
    list-style-type: none;
    button {
      background: rgba(0, 0, 0, 0.03);
    }
    .nav-link {
      border: none !important;
    }
  }
}
</style>
