<template>
  <div
    ref="dropdownMenu"
    class="dropdown-menu dropdown-menu-right show"
    :class="`dropdown-menu-${size}`"
    :style="fixStyles"
  >
    <slot></slot>
  </div>
</template>
<script lang="ts">
import { Component, Vue, Prop } from "vue-property-decorator";

@Component({
  name: "app-dropdown-menu",
})
export default class DropdownMenu extends Vue {
  @Prop({ type: String, default: null }) readonly size: string | undefined;
  private dropdownMenuElement: HTMLElement | null = null;

  public mounted(): void {
    this.dropdownMenuElement = this.$refs.dropdownMenu as HTMLElement;
  }

  get fixStyles(): any {
    if (this.dropdownMenuElement) {
      const windowWidth = document.getElementById("app")?.offsetWidth;
      const offsetLeft = this.dropdownMenuElement.getBoundingClientRect().left;
      const offsetWidth = this.dropdownMenuElement.offsetWidth;
      // @ts-ignore
      const visiblePart = windowWidth - offsetLeft;

      if (offsetLeft < 0) {
        return {
          left: "inherit",
          right: `${offsetLeft - 5}px`,
        };
      } else if (visiblePart < offsetWidth) {
        return { left: "inherit", right: `0px` };
      }
      return { left: "inherit", right: `0px` };
    }
    return { left: "inherit", right: `0px` };
  }
}
</script>
