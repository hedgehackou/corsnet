<template>
  <div class="wrapper">
    <AppHeader @toggle-menu-sidebar="toggleMenuSidebar" />
    <MenuSidebar />
    <AppFooter v-if="false" />
    <div
      id="sidebar-overlay"
      v-if="screenSize === 'xs' && isSidebarMenuCollapsed"
      @click="toggleMenuSidebar"
    ></div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import Header from "@/modules/main/header/Header.vue";
import MenuSidebar from "@/modules/main/menu-sidebar/MenuSidebar.vue";
import Footer from "@/modules/main/footer/Footer.vue";

@Component({
  components: {
    AppHeader: Header,
    AppFooter: Footer,
    MenuSidebar: MenuSidebar,
  },
  watch: {
    watchLayoutChanges: (value) => value,
  },
})
export default class Index extends Vue {
  private appElement: HTMLElement | null = null;

  public toggleMenuSidebar(): void {
    this.$store.dispatch("toggleSidebarMenu");
  }

  public async mounted(): Promise<void> {
    this.appElement = document.getElementById("app") as HTMLElement;
    this.appElement.classList.add("sidebar-mini");
    this.appElement.classList.add("layout-fixed");
  }

  public unmounted(): void {
    this.appElement!.classList.remove("sidebar-mini");
    this.appElement!.classList.remove("layout-fixed");
  }

  get screenSize() {
    return this.$store.getters["screenSize"];
  }
  get isSidebarMenuCollapsed() {
    return this.$store.getters["isSidebarMenuCollapsed"];
  }

  get watchLayoutChanges() {
    if (!this.appElement) {
      return null;
    }
    this.appElement.classList.remove("sidebar-closed");
    this.appElement.classList.remove("sidebar-collapse");
    this.appElement.classList.remove("sidebar-open");
    if (this.isSidebarMenuCollapsed && this.screenSize === "lg") {
      this.appElement.classList.add("sidebar-collapse");
    } else if (this.isSidebarMenuCollapsed && this.screenSize === "xs") {
      this.appElement.classList.add("sidebar-open");
    } else if (!this.isSidebarMenuCollapsed && this.screenSize !== "lg") {
      this.appElement.classList.add("sidebar-closed");
      this.appElement.classList.add("sidebar-collapse");
    }
    return this.appElement.classList.value;
  }
}
</script>

<style scoped></style>
