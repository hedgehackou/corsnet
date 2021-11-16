<template>
  <app-dropdown class="user-menu">
    <template v-slot:dropdown-button>
      <img
        :src="require('@/assets/img/default-profile.png')"
        class="user-image img-circle elevation-2"
        alt="User Image"
      />
    </template>
    <template v-slot:dropdown-menu>
      <li class="user-header bg-primary">
        <img
          :src="require('@/assets/img/default-profile.png')"
          class="img-circle elevation-2"
          alt="User Image"
        />

        <p>
          <span>{{ userProfile && userProfile.email }}</span>
        </p>
      </li>
      <li class="user-footer">
        <a
          href="#"
          class="btn btn-default btn-flat"
          @click="isDropdownOpened = false"
        >
          {{ $t("index.profile") }}
        </a>
        <button @click="logout" class="btn btn-default btn-flat float-right">
          {{ $t("auth.signOut") }}
        </button>
      </li>
    </template>
  </app-dropdown>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import Dropdown from "@/components/dropdown/Dropdown.vue";
import StoreModule from "@/store/StoreModule";
import { AuthStoreModule } from "@/modules/auth/store/AuthStore";
import { namespace } from "vuex-class";
StoreModule.registerMany({
  AuthStoreModule,
});

const authStore = namespace("AuthStoreModule");

@Component({
  components: {
    "app-dropdown": Dropdown,
  },
})
export default class UserDropdown extends Vue {
  @authStore.Action("logout")
  logoutAction!: () => Promise<any>;

  public onToggleMenuSidebar(): void {
    this.$emit("toggle-menu-sidebar");
  }
  get userProfile() {
    return this.$store.getters["AuthStore/userProfile"] || {};
  }

  async logout() {
    await this.logoutAction();
    this.$toast.success(this.$t("auth.logoutSuccess") as string);
    await this.$router
      .push({
        name: "login",
      })
      .catch(() => null);
  }
}
</script>

<style scoped></style>
