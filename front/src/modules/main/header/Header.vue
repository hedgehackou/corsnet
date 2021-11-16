<template>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <button @click="onToggleMenuSidebar" class="nav-link" role="button">
          <i class="fas fa-bars"></i>
        </button>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <UserDropdown></UserDropdown>
    </ul>
  </nav>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import UserDropdown from "@/modules/main/user-dropdown/UserDropdown.vue";

@Component({
  components: {
    UserDropdown,
  },
})
export default class Header extends Vue {
  public onToggleMenuSidebar(): void {
    this.$emit("toggle-menu-sidebar");
  }
}
</script>

<style scoped></style>
