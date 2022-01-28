<template>
  <section class="content">
    <div class="container-fluid overflow-hidden">
      <b-tabs class="mt-4" content-class="mt-3">
        <b-tab :title="$t('settings.main')">
          <MainUnit />
        </b-tab>
        <b-tab active :title="null">
          <template #title>
            {{ $t("settings.pages") }}
          </template>
          <PagesUnit />
        </b-tab>
      </b-tabs>
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import FormErrorListPrinter from "@/components/form/FormErrorListPrinter.vue";

import MainUnit from "@/modules/settings/components/MainUnit.vue";
import PagesUnit from "@/modules/settings/components/PagesUnit.vue";

@Component({
  components: {
    FormErrorListPrinter,
    MainUnit,
    PagesUnit,
  },
})
export default class Settings extends Vue {}
</script>
