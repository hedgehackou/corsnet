<template>
  <div class="w-100">
    <Install></Install>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import Install from "@/modules/install/Install.vue";

@Component({
  components: {
    Install,
  },
})
export default class Main extends Vue {}
</script>

<style scoped></style>
