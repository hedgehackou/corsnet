<template>
  <li class="nav-item" :class="{ 'menu-open': isMenuExtended }">
    <a
      class="nav-link"
      :class="{ active: isMainActive || isOneOfChildrenActive }"
      @click="handleMainMenuAction"
    >
      <i class="nav-icon fas fa-tachometer-alt"></i>
      <p>{{ $t(menuItem.name) }}</p>
      <i v-if="isExpandable" class="right fas fa-angle-left"></i>
    </a>
    <ul
      class="nav nav-treeview"
      :key="index"
      v-for="(item, index) in menuItem.children"
    >
      <li class="nav-item">
        <router-link
          :to="item.path"
          class="nav-link"
          exact
          exact-active-class="active"
        >
          <i class="far fa-circle nav-icon"></i>
          <p>{{ $t(item.name) }}</p>
        </router-link>
      </li>
    </ul>
  </li>
</template>

<script lang="ts">
import { Component, Vue, Prop } from "vue-property-decorator";

@Component({
  components: {},
})
export default class MenuItem extends Vue {
  @Prop({ type: Object, default: () => ({}) }) menuItem: any;

  private isMenuExtended: boolean = false;
  private isExpandable: boolean = false;
  private isMainActive: boolean = false;
  private isOneOfChildrenActive: boolean = false;

  public mounted(): void {
    this.isExpandable =
      this.menuItem &&
      this.menuItem.children &&
      this.menuItem.children.length > 0;
    this.calculateIsActive(this.$router.currentRoute.path);
    this.$router.afterEach((to) => {
      this.calculateIsActive(to.path);
    });
  }

  public handleMainMenuAction() {
    if (this.isExpandable) {
      this.toggleMenu();
      return;
    }
    this.$router.replace(this.menuItem.path);
  }

  public toggleMenu() {
    this.isMenuExtended = !this.isMenuExtended;
  }

  public isRootPath(path: string) {
    const routeName = this.$route.name;
    if (routeName === "admin-dashboard" || routeName === "user-dashboard") {
      return false;
    }

    return ["/admin", "/user"].includes(path);
  }

  public calculateIsActive(url: string) {
    url = url.replace(/\/en|\/ru/i, "/");
    url = url.replace(/\/$/, "");
    this.isMainActive = false;
    this.isOneOfChildrenActive = false;
    if (this.isExpandable) {
      this.menuItem.children.forEach((item: any) => {
        if (url.startsWith(item.path)) {
          this.isOneOfChildrenActive = true;
          this.isMenuExtended = true;
        }
      });
    } else if (
      url.startsWith(this.menuItem.path) &&
      !this.isRootPath(this.menuItem.path)
    ) {
      this.isMainActive = true;
    }
    if (!this.isMainActive && !this.isOneOfChildrenActive) {
      this.isMenuExtended = false;
    }
  }
}
</script>

<style scoped>
.nav-item {
  cursor: pointer;
}
</style>
