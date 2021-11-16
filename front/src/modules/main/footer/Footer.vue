<template>
  <footer class="main-footer">
    <strong v-if="false">
      <span>Copyright &copy; 2021</span>
      <a href="#" target="_blank" rel="noopener noreferrer">
        <span>test.com</span>
      </a>
      <span>.</span>
    </strong>
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b>
      <span>:&nbsp;{{ version }}</span>
    </div>
  </footer>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";

@Component({
  components: {},
})
export default class Footer extends Vue {
  private version: string = "1.0.0";
}
</script>

<style scoped></style>
