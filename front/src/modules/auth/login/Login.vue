<template>
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="#" class="h1">{{ settings.network_name }}</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">{{ $t("auth.signInToStart") }}</p>

        <form @submit.prevent="loginByAuth">
          <div class="input-group mb-1 mt-2">
            <input
              type="email"
              class="form-control"
              placeholder="Email"
              v-model="email"
            />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa fa-envelope"></span>
              </div>
            </div>
          </div>
          <form-error-list-printer :error-list="loginErrors.email" />
          <div class="input-group mb-1 mt-3">
            <input
              type="password"
              class="form-control"
              placeholder="Password"
              v-model="password"
            />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa fa-lock"></span>
              </div>
            </div>
          </div>
          <form-error-list-printer :error-list="loginErrors.password" />

          <div class="row">
            <!-- /.col -->
            <div class="col-12">
              <button class="mt-4 btn btn-primary w-100" type="submit">
                {{ $t("auth.signIn") }}
              </button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mb-0 mt-2">
          <router-link :to="{ name: 'forgot-password' }">
            {{ $t("auth.forgotPassword") }}
          </router-link>
        </p>
        <p v-if="allowUserSignUp" class="mb-0 mt-0">
          <router-link :to="{ name: 'sign-up' }">
            {{ $t("auth.signUp") }}
          </router-link>
        </p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
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
import { SettingsStoreModule } from "@/modules/settings/store/SettingsStore";

StoreModule.registerMany({
  AuthStoreModule,
  SettingsStoreModule,
});

const settingsStore = namespace("SettingsStoreModule");
const authStore = namespace("AuthStoreModule");

@Component({
  components: {
    Languages,
    FormErrorListPrinter,
  },
})
export default class Login extends Vue {
  private appElement: HTMLElement | null = null;
  public email = "";
  public password = "";
  public allowUserSignUp = false;

  public loginErrors = {
    email: null,
    password: null,
  };

  @authStore.Getter("getSettings")
  public settings!: { network_name: string };

  @authStore.Action("login")
  loginAction!: (payload: any) => Promise<any>;

  @authStore.Action("verifyEmail")
  verifyEmailAction!: (token: string) => Promise<any>;

  @settingsStore.Action("allowUserSignUp")
  allowUserSignUpAction!: () => Promise<boolean>;

  public async mounted(): Promise<void> {
    this.appElement = document.getElementById("app") as HTMLElement;
    this.appElement.classList.add("login-page");
    if (await this.allowUserSignUpAction()) {
      this.allowUserSignUp = true;
    }
    if (this.$route.query.emailVerificationToken) {
      try {
        await this.verifyEmailAction(
          this.$route.query.emailVerificationToken as string
        );
        this.$toast.success(
          this.$t("auth.emailVerifiedSuccessfully") as string
        );
      } catch (e) {
        this.$toast.success(this.$t("auth.emailAlreadyVerified") as string);
      } finally {
        await this.$router.replace({});
      }
    }
  }

  public unmounted(): void {
    this.removeAppClass();
  }

  public removeAppClass() {
    (this.appElement as HTMLElement).classList.remove("login-page");
  }

  public async loginByAuth(): Promise<void> {
    let loader = this.$loading.show();
    try {
      const { token, abilities } = await this.loginAction({
        email: this.email,
        password: this.password,
      });
      localStorage.setItem("auth_token", token);
      localStorage.setItem("auth_abilities", abilities);
      this.axios.defaults.headers = {
        //@ts-ignore
        Authorization: `Bearer ${token}`,
        Accept: "application/json",
      };
      this.$toast.success(this.$t("auth.loginSuccess") as string);
      this.removeAppClass();
      await this.$router.push({
        name: "admin-dashboard",
      });
    } catch (error: any) {
      if (error.response) {
        this.loginErrors = error.response.data.errors;
        this.$toast.error(this.$t("auth.loginError") as string);
      }
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
