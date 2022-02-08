<template>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <router-link to="/" class="brand-link">
      <span class="brand-text font-weight-light ml-4">
        {{ settings.network_name }}
      </span>
    </router-link>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img
            :src="require('@/assets/img/default-profile.png')"
            class="img-circle elevation-2"
            alt="User Image"
          />
        </div>
        <div class="info">
          <a href="#" class="d-block">
            {{ userProfile.email }}
          </a>
        </div>
      </div>

      <nav class="mt-2">
        <ul
          class="nav nav-pills nav-sidebar flex-column"
          data-widget="treeview"
          role="menu"
          data-accordion="false"
        >
          <menu-item
            :key="index"
            v-for="(item, index) in menu"
            :menuItem="item"
          ></menu-item>
        </ul>
      </nav>
    </div>
  </aside>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import MenuItem from "@/modules/main/menu-item/MenuItem.vue";
import { namespace } from "vuex-class";
import StoreModule from "@/store/StoreModule";
import { AuthStoreModule } from "@/modules/auth/store/AuthStore";
const authStore = namespace("AuthStoreModule");

StoreModule.registerMany({
  AuthStoreModule,
});

@Component({
  components: {
    MenuItem,
  },
})
export default class MenuSidebar extends Vue {
  public menu = [...(this.userProfile.is_admin ? ADMIN_MENU : USER_MENU)];

  @authStore.Getter("getSettings")
  public settings!: { network_name: string };

  get userProfile() {
    return this.$store.getters["AuthStore/userProfile"] || {};
  }
}

export const ADMIN_MENU = [
  {
    name: "index.dashboard",
    path: "/admin",
  },
  {
    name: "index.invitations",
    path: "/admin/invitations",
  },
  {
    name: "index.users",
    path: "/admin/users",
  },
  {
    name: "index.bases",
    path: "/admin/base-stations",
  },
  {
    name: "index.casters",
    path: "/admin/casters",
  },
  {
    name: "index.settings",
    path: "/admin/settings",
  },
];
export const USER_MENU = [
  {
    name: "index.dashboard",
    path: "/user",
  },
  {
    name: "index.bases",
    path: "/user/base-stations",
  },
];
</script>

<style scoped></style>
