<template>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <router-link to="/" class="brand-link">
      <img
        src="@/assets/logo.png"
        alt="AdminLTE Logo"
        class="brand-image img-circle elevation-3"
        style="opacity: 0.8"
      />
      <span class="brand-text font-weight-light">AdminLTE 3</span>
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

@Component({
  components: {
    MenuItem,
  },
})
export default class MenuSidebar extends Vue {
  public menu = MENU;
  get userProfile() {
    return this.$store.getters["AuthStore/userProfile"] || {};
  }
}

export const MENU = [
  {
    name: "index.dashboard",
    path: "/admin",
  },
  {
    name: "index.user",
    path: "/user",
  },
];
</script>

<style scoped></style>
