<template>
  <div class="login-box" v-if="componentLoaded">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="#" class="h1">{{ settings.network_name }}</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">{{ $t("auth.signUpToStart") }}</p>

        <form @submit.prevent="signUp">
          <div class="input-group mb-1 mt-2">
            <input
              class="form-control"
              :placeholder="$t('invite.name')"
              v-model="signUpParams.name"
            />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa fa-user"></span>
              </div>
            </div>
          </div>
          <form-error-list-printer :error-list="signUpErrors.name" />
          <div class="input-group mb-1 mt-2">
            <input
              type="email"
              class="form-control"
              placeholder="Email"
              v-model="signUpParams.email"
            />
            <div class="input-group-append">
              <div class="input-group-text" style="width: 40px">
                <span class="fa fa-envelope"></span>
              </div>
            </div>
          </div>
          <form-error-list-printer :error-list="signUpErrors.email" />
          <div class="input-group mb-1 mt-2">
            <input
              type="password"
              class="form-control"
              placeholder="Password"
              v-model="signUpParams.password"
            />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa fa-lock"></span>
              </div>
            </div>
          </div>
          <form-error-list-printer :error-list="signUpErrors.password" />
          <div class="input-group mb-1 mt-2">
            <input
              type="password"
              class="form-control"
              placeholder="Password confirmation"
              v-model="signUpParams.password_confirmation"
            />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa fa-lock"></span>
              </div>
            </div>
          </div>
          <form-error-list-printer
            :error-list="signUpErrors.password_confirmation"
          />

          <div class="row">
            <!-- /.col -->
            <div class="col-12">
              <button class="mt-4 btn btn-primary w-100" type="submit">
                {{ $t("auth.signUp") }}
              </button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mb-0 mt-2">
          <router-link :to="{ name: 'login' }">
            {{ $t("auth.signIn") }}
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
import { NavigationGuardNext, Route } from "vue-router/types/router";
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
  beforeRouteEnter(to: Route, from: Route, next: NavigationGuardNext) {
    next((vm: any) => {
      vm.allowUserSignUpAction()
        .then((allow: boolean) => {
          if (allow) {
            vm.componentLoaded = true;
          } else {
            vm.$router.push({ name: "login" });
          }
        })
        .catch(() => {
          vm.$router.push({ name: "login" });
        });
    });
  },
})
export default class SignUp extends Vue {
  private appElement: HTMLElement | null = null;
  public componentLoaded: boolean = false;
  public signUpDefaultParams = {
    email: null,
    name: null,
    password: null,
    password_confirmation: null,
  };
  public signUpParams = {
    ...this.signUpDefaultParams,
  };

  public signUpErrors = {
    ...this.signUpDefaultParams,
  };

  @settingsStore.Action("allowUserSignUp")
  allowUserSignUpAction!: () => Promise<boolean>;

  @authStore.Getter("getSettings")
  public settings!: { network_name: string };

  @authStore.Action("signUp")
  signUpAction!: (payload: any) => Promise<any>;

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

  public async signUp(): Promise<void> {
    let loader = this.$loading.show();
    try {
      await this.signUpAction(this.signUpParams);
      this.$toast.success(this.$t("auth.signUpSuccess") as string);
      this.removeAppClass();
      await this.$router.push({
        name: "login",
      });
    } catch (error: any) {
      if (error.response) {
        this.signUpErrors = error.response.data.errors;
        this.$toast.error(this.$t("auth.signUpError") as string);
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
