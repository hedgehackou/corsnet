<template>
  <section class="content">
    <div class="container-fluid overflow-hidden">
      <b-table
        class="caster-view-table mt-4"
        responsive
        show-empty
        stacked
        :items="tableItems"
        :fields="getBaseStationTableFields"
      >
        <template #cell(nmea)="{ item }">
          <b-check disabled v-model="item.nmea"></b-check>
        </template>
        <template #cell(country_id)="{ item }">
          <b-select
            disabled
            style="max-width: 100px"
            :options="getCountries"
            v-model="item.country_id"
          >
          </b-select>
        </template>
      </b-table>
      <div class="">
        <b-button
          @click="editBaseStation"
          class="mb-3 mt-3"
          variant="primary"
          >{{ $t("baseStations.edit") }}</b-button
        >
      </div>
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Prop, Vue } from "vue-property-decorator";
import FormErrorListPrinter from "@/components/form/FormErrorListPrinter.vue";
import { namespace } from "vuex-class";
import StoreModule from "@/store/StoreModule";

import { CasterStoreModule } from "@/modules/admin/casters/store/CasterStore";

const casterStoreModule = namespace("CasterStoreModule");
StoreModule.registerMany({
  CasterStoreModule,
});

@Component({
  components: {
    FormErrorListPrinter,
  },
})
export default class ViewCaster extends Vue {
  @Prop({ type: Number, required: false, default: null })
  readonly casterId: any;

  public casterParams = {
    name: "-",
    host: "-",
    port: "-",
    operator: "-",
    nmea: "-",
    country_id: "-",
    latitude: "-",
    longitude: "-",
    fallback_host: "-",
    fallback_port: "-",
    misc: "-",
  };

  @casterStoreModule.Action("getCaster")
  getCasterAction!: (id: any) => Promise<any>;

  @casterStoreModule.Action("getCountries")
  getCountriesAction!: () => Promise<any>;

  @casterStoreModule.Getter("getCountries")
  public getCountries!: any[];

  public get tableItems() {
    return [this.casterParams];
  }

  public get getBaseStationTableFields() {
    return [
      { key: "name", label: this.$t("caster.name") + ":" },
      { key: "host", label: this.$t("caster.host") + ":" },
      { key: "port", label: this.$t("caster.port") + ":" },
      { key: "operator", label: this.$t("caster.operator") + ":" },
      { key: "nmea", label: this.$t("caster.nmea") + ":" },
      { key: "country_id", label: this.$t("caster.country") + ":" },
      { key: "latitude", label: this.$t("caster.latitude") + ":" },
      { key: "longitude", label: this.$t("caster.longitude") + ":" },
      { key: "fallback_host", label: this.$t("caster.fallbackHost") + ":" },
      { key: "fallback_port", label: this.$t("caster.fallbackPort") + ":" },
      { key: "misc", label: this.$t("caster.misc") + ":" },
    ];
  }

  public editBaseStation() {
    this.$router.push({
      name: `admin-edit-caster`,
      params: { casterId: this.casterId },
    });
  }

  public async mounted() {
    const { data: result } = await this.getCasterAction(this.casterId);
    Object.assign(this.casterParams, result);
    await this.getCountriesAction();
  }
}
</script>

<style lang="scss">
.caster-view-table {
  td:before {
    width: auto !important;
  }
}
</style>
