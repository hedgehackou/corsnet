<template>
  <div class="login-box" v-if="componentLoaded">
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">{{ $t("invite.acceptInvite") }}</p>
        <form @submit.prevent="acceptInvite">
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
          <div class="input-group mb-1 mt-3">
            <input
              v-model="name"
              class="form-control"
              :placeholder="$t('invite.name')"
            />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa fa-user"></span>
              </div>
            </div>
          </div>
          <form-error-list-printer :error-list="acceptInviteErrors.name" />
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
          <form-error-list-printer :error-list="acceptInviteErrors.password" />
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
            :error-list="acceptInviteErrors.password_confirmation"
          />
          <div class="row mt-3">
            <div class="col-12">
              <button
                type="submit"
                class="btn btn-primary btn-block white-space-no-wrap"
              >
                <i class="fa fa-sign-in"></i> {{ $t("invite.send") }}
              </button>
            </div>
          </div>
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

import { namespace } from "vuex-class";
import StoreModule from "@/store/StoreModule";
import { InviteStoreModule } from "@/modules/admin/invitations/store/InviteStore";
import { NavigationGuardNext, Route } from "vue-router/types/router";

const inviteStore = namespace("InviteStoreModule");
StoreModule.registerMany({
  InviteStoreModule,
});

@Component({
  components: {
    Languages,
    FormErrorListPrinter,
  },
  beforeRouteEnter(to: Route, from: Route, next: NavigationGuardNext) {
    next((vm: any) => {
      vm.getInviteInfoAction(vm.$route.params.token)
        .then((data: any) => {
          vm.componentLoaded = true;
          vm.email = data.data.email;
        })
        .catch(() => {
          vm.$router.push({ name: "login" });
        });
    });
  },
})
export default class AcceptInvite extends Vue {
  private appElement: HTMLElement | null = null;

  public componentLoaded = false;
  public email: string = "";
  public name: string = "";
  public password: string = "";
  public passwordConfirmation: string = "";
  public token: string = "";

  public acceptInviteErrors = {
    name: null,
    password: null,
    passwordConfirmation: null,
  };

  @inviteStore.Action("acceptInvite")
  acceptInviteAction!: (payload: any) => Promise<any>;

  @inviteStore.Action("getInviteInfo")
  getInviteInfoAction!: (payload: any) => Promise<any>;

  public mounted(): void {
    this.appElement = document.getElementById("app") as HTMLElement;
    this.appElement.classList.add("login-page");
    this.token = this.$route.params.token;
  }

  public unmounted(): void {
    this.removeAppClass();
  }

  public removeAppClass() {
    (this.appElement as HTMLElement).classList.remove("login-page");
  }

  public async acceptInvite(): Promise<void> {
    let loader = this.$loading.show();

    this.acceptInviteErrors = {
      name: null,
      password: null,
      passwordConfirmation: null,
    };

    try {
      await this.acceptInviteAction({
        name: this.name,
        password: this.password,
        passwordConfirmation: this.passwordConfirmation,
        token: this.token,
      });
      this.$toast.success(this.$t("invite.acceptedSuccessfully") as string);
      this.removeAppClass();
      await this.$router.push({
        name: "login",
      });
    } catch (error: any) {
      this.acceptInviteErrors = error.response.data.errors;
      this.$toast.error(this.$t("invite.acceptInviteError") as string);
    } finally {
      loader.hide();
    }
  }
}
</script>
