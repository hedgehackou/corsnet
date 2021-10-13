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
import { Component, Vue } from "vue-property-decorator";

@Component({
  name: "app-dropdown-menu",
  props: {
    size: String,
  },
})
export default class DropdownMenu extends Vue {
  private dropdownMenuElement: HTMLElement | null = null;
  public size: string | null = null;

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
