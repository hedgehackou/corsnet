<template>
  <li class="nav-item dropdown" ref="dropdown">
    <button class="nav-link" @click="toggleDropdown">
      <slot name="dropdown-button"></slot>
    </button>

    <app-dropdown-menu v-if="isOpen" :size="size">
      <slot name="dropdown-menu"></slot>
    </app-dropdown-menu>
  </li>
</template>

<script lang="ts">
import { Component, Vue, Prop } from "vue-property-decorator";
import DropdownMenu from "./DropdownMenu.vue";

@Component({
  name: "app-dropdown",
  components: {
    "app-dropdown-menu": DropdownMenu,
  },
})
export default class Dropdown extends Vue {
  @Prop({ type: String, default: "md" }) readonly size: string | undefined;

  private dropdownElement!: HTMLElement;
  public isOpen = false;

  public mounted(): void {
    this.dropdownElement = this.$refs.dropdown as HTMLElement;
    document.addEventListener("click", this.documentClick);
  }

  public unmounted(): void {
    document.removeEventListener("click", this.documentClick);
  }

  private documentClick(event: Event) {
    const target: HTMLElement = event.target as HTMLElement;
    if (
      this.dropdownElement !== target &&
      !this.dropdownElement.contains(target)
    ) {
      this.isOpen = false;
    }
  }

  private toggleDropdown() {
    this.isOpen = !this.isOpen;
  }
}
</script>
