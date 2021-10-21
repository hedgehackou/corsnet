<template>
  <p class="error-block">
    <span class="text-danger" v-for="(error, index) in errorList" :key="index">
      {{ error }}
    </span>
  </p>
</template>

<script lang="ts">
import { Component, Prop, Vue } from "vue-property-decorator";

@Component({
  name: "FormErrorListPrinter",
})
export default class FormErrorListPrinter extends Vue {
  @Prop({ type: Array, required: false, default: [] })
  readonly errorList: any;
}
</script>

<style scoped>
.error-block {
  width: 100%;
  margin: 0;
  padding: 0;
}
</style>
