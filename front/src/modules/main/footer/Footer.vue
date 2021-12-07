<template>
  <footer class="main-footer">
    <strong v-if="true">
      <span>Copyright &copy; 2021 </span>
      <a @click.prevent="" href="#" target="_blank" rel="noopener noreferrer">
        <span>corsnet.xyz</span>
      </a>
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
  private version: string = process.env.VUE_APP_VERSION;
}
</script>

<style scoped></style>
