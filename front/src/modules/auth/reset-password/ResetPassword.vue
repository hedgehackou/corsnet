<template>
  <div class="login-box">
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">{{ $t("auth.resetPassword") }}</p>
        <form @submit.prevent="resetPassword">
          <div class="input-group mb-1 mt-2">
            <input
              type="email"
              disabled
              v-model="email"
              class="form-control"
              placeholder="Email"
              autofocus
            />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa fa-envelope"></span>
              </div>
            </div>
          </div>
          <form-error-list-printer :error-list="resetPasswordErrors.email" />
          <div class="input-group mb-1 mt-3">
            <input
              type="password"
              v-model="password"
              class="form-control"
              :placeholder="$t('auth.newPassword')"
            />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa fa-lock"></span>
              </div>
            </div>
          </div>
          <form-error-list-printer :error-list="resetPasswordErrors.password" />
          <div class="input-group mb-1 mt-3">
            <input
              type="password"
              v-model="passwordConfirmation"
              class="form-control"
              :placeholder="$t('auth.confirmNewPassword')"
            />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa fa-lock"></span>
              </div>
            </div>
          </div>
          <form-error-list-printer
            :error-list="resetPasswordErrors.password_confirmation"
          />
          <div class="row mt-3">
            <div class="col-12">
              <button
                type="submit"
                class="btn btn-primary btn-block white-space-no-wrap"
              >
                <i class="fa fa-sign-in"></i> {{ $t("auth.send") }}
              </button>
            </div>
          </div>
          <p class="mb-0 mt-2">
            <router-link :to="{ name: 'login' }">
              {{ $t("auth.signIn") }}
            </router-link>
          </p>
        </form>
      </div>
    </div>
  </div>
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
export default class ResetPassword extends Vue {
  private appElement: HTMLElement | null = null;

  public email: string = "";
  public password: string = "";
  public passwordConfirmation: string = "";
  public token: string = "";

  public resetPasswordErrors = {
    email: null,
    password: null,
    passwordConfirmation: null,
  };

  @authStore.Action("resetPassword")
  resetPasswordAction!: (payload: any) => Promise<any>;

  public mounted(): void {
    this.appElement = document.getElementById("app") as HTMLElement;
    this.appElement.classList.add("login-page");
    this.token = this.$route.params.token;
    this.email = this.$route.query.email as string;
  }

  public unmounted(): void {
    this.removeAppClass();
  }

  public removeAppClass() {
    (this.appElement as HTMLElement).classList.remove("login-page");
  }

  public async resetPassword(): Promise<void> {
    let loader = this.$loading.show();

    this.resetPasswordErrors = {
      email: null,
      password: null,
      passwordConfirmation: null,
    };

    try {
      await this.resetPasswordAction({
        email: this.email,
        password: this.password,
        passwordConfirmation: this.passwordConfirmation,
        token: this.token,
      });
      this.$toast.success(this.$t("auth.passwordResetSuccessfully") as string);
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
