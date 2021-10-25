<template>
  <div class="wrapper">
    <AppHeader />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import Header from "@/modules/main/header/Header.vue";

@Component({
  components: {
    AppHeader: Header,
  },
})
export default class Index extends Vue {}
</script>

<style scoped></style>
