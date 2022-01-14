<template>
  <section class="content">
    <div class="container-fluid overflow-hidden">
      <b-tabs class="mt-4" content-class="mt-3">
        <b-tab :title="$t('users.clients')">
          <Clients />
        </b-tab>
      </b-tabs>
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import FormErrorListPrinter from "@/components/form/FormErrorListPrinter.vue";
import StoreModule from "@/store/StoreModule";

import { BaseStationStoreModule } from "@/modules/admin/base-stations/store/BaseStationStore";
import Clients from "@/modules/admin/users/components/Clients.vue";

StoreModule.registerMany({
  BaseStationStoreModule,
});

@Component({
  components: {
    FormErrorListPrinter,
    Clients,
  },
})
export default class UsersView extends Vue {}
</script>

<style lang="scss">
.base-station-view-table {
  td:before {
    width: auto !important;
  }
}
.base-station-name {
  font-size: 18px;
  margin-top: 14px;
  font-weight: bold;
  display: flex;
  align-items: center;
}
.base-station-status {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  margin-left: 5px;
}
.base-station-status-green {
  background-color: green;
}
.base-station-status-red {
  background-color: red;
}
</style>
