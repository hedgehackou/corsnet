<template>
  <div>
    <Languages v-if="false"></Languages>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import Languages from "@/components/languages/Languages.vue";

@Component({
  components: {
    Languages,
  },
})
export default class Install extends Vue {
  private appElement: HTMLElement | null = null;

  public mounted() {
    this.appElement = document.getElementById("app") as HTMLElement;
    this.appElement.classList.add("login-page");
  }

  public unmounted(): void {
    (this.appElement as HTMLElement).classList.remove("login-page");
  }
}
</script>

<style scoped></style>
