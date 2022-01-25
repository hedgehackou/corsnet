<template>
  <section class="content">
    <div class="container-fluid overflow-hidden">
      <div class="">
        <div class="form-group mb-0">
          <div class="mt-2">{{ $t("caster.caster") }}</div>
          <b-input
            v-model="casterParams.name"
            type="text"
            class="form-control mt-1"
          />
        </div>
        <form-error-list-printer :error-list="casterErrors.name" />
        <div class="form-group mb-0">
          <div class="mt-2">{{ $t("caster.host") }}</div>
          <b-input
            v-model="casterParams.host"
            type="text"
            class="form-control mt-1"
          />
        </div>
        <form-error-list-printer :error-list="casterErrors.host" />
        <div class="form-group mb-0">
          <div class="mt-2">{{ $t("caster.port") }}</div>
          <b-input
            v-model="casterParams.port"
            type="number"
            class="form-control mt-1"
          />
        </div>
        <form-error-list-printer :error-list="casterErrors.port" />
        <div class="form-group mb-0">
          <div class="mt-2">{{ $t("caster.operator") }}</div>
          <b-input v-model="casterParams.operator" class="form-control mt-1" />
        </div>
        <form-error-list-printer :error-list="casterErrors.operator" />
        <div class="form-group mb-0">
          <div class="mt-2">{{ $t("caster.nmea") }}</div>
          <b-check v-model="casterParams.nmea" class="mt-1" />
        </div>
        <form-error-list-printer :error-list="casterErrors.nmea" />
        <div class="form-group mb-0">
          <div class="mt-2">{{ $t("caster.country") }}</div>
          <b-select :options="getCountries" v-model="casterParams.country_id">
            <template #first>
              <b-form-select-option :value="null" disabled>{{
                $t("caster.selectCountry")
              }}</b-form-select-option>
            </template>
          </b-select>
        </div>
        <form-error-list-printer :error-list="casterErrors.country_id" />
        <div class="form-group mb-0">
          <div class="mt-2">{{ $t("caster.latitude") }}</div>
          <b-input
            v-model="casterParams.latitude"
            type="number"
            class="form-control mt-1"
          />
        </div>
        <form-error-list-printer :error-list="casterErrors.latitude" />
        <div class="form-group mb-0">
          <div class="mt-2">{{ $t("caster.longitude") }}</div>
          <b-input
            v-model="casterParams.longitude"
            type="number"
            class="form-control mt-1"
          />
        </div>
        <form-error-list-printer :error-list="casterErrors.longitude" />
        <div class="form-group mb-0">
          <div class="mt-2">{{ $t("caster.fallbackHost") }}</div>
          <b-input
            v-model="casterParams.fallback_host"
            class="form-control mt-1"
          />
        </div>
        <form-error-list-printer :error-list="casterErrors.fallback_host" />
        <div class="form-group mb-0">
          <div class="mt-2">{{ $t("caster.fallbackPort") }}</div>
          <b-input
            v-model="casterParams.fallback_port"
            type="number"
            class="form-control mt-1"
          />
        </div>
        <form-error-list-printer :error-list="casterErrors.fallback_port" />
        <div class="form-group mb-0">
          <div class="mt-2">{{ $t("caster.misc") }}</div>
          <b-input v-model="casterParams.misc" class="form-control mt-1" />
        </div>
        <form-error-list-printer :error-list="casterErrors.misc" />

        <b-button
          v-if="editMode"
          @click="saveCaster"
          class="mb-3 mt-3"
          variant="primary"
          >{{ $t("caster.save") }}</b-button
        >
        <b-button
          v-else
          @click="createCaster"
          class="mb-3 mt-3"
          variant="primary"
          >{{ $t("caster.create") }}</b-button
        >
        <b-button
          v-if="editMode"
          @click="refreshCaster(casterId)"
          class="mb-3 mt-3 ml-3"
          variant="primary"
          ><div class="fa fa-sync"></div
        ></b-button>
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
export default class CreateEditCaster extends Vue {
  @Prop({ type: Boolean, required: false, default: false })
  readonly editMode: any;

  @Prop({ type: Number, required: false, default: null })
  readonly casterId: any;

  public casterDefaultParams = {
    name: null,
    host: null,
    port: null,
    operator: null,
    nmea: null,
    country_id: null,
    latitude: null,
    longitude: null,
    fallback_host: null,
    fallback_port: null,
    misc: null,
  };
  public casterParams = { ...this.casterDefaultParams };
  public casterErrors = { ...this.casterDefaultParams };

  @casterStoreModule.Action("createCaster")
  createCasterAction!: (payload: any) => Promise<any>;

  @casterStoreModule.Action("updateCaster")
  updateCasterAction!: (payload: any) => Promise<any>;

  @casterStoreModule.Action("getCaster")
  getCasterAction!: (id: any) => Promise<any>;

  @casterStoreModule.Action("getCountries")
  getCountriesAction!: () => Promise<any>;

  @casterStoreModule.Getter("getCountries")
  public getCountries!: any[];

  @casterStoreModule.Action("refreshCaster")
  refreshCasterAction!: (casterId: string) => Promise<any>;

  public async saveCaster() {
    this.casterErrors = { ...this.casterDefaultParams };
    let loader = this.$loading.show();
    try {
      await this.updateCasterAction({
        ...this.casterParams,
        casterId: this.casterId,
      });
      this.$toast.success(this.$t("caster.success") as string);
    } catch (e) {
      this.$toast.error(this.$t("caster.error") as string);
      this.casterErrors = e.response.data.errors;
    } finally {
      loader.hide();
    }
  }

  public async refreshCaster(casterId: string) {
    let loader = this.$loading.show();
    try {
      await this.refreshCasterAction(casterId);
      this.$toast.success(this.$t("caster.updatedSuccessfully") as string);
    } catch (e) {
      this.$toast.error(this.$t("caster.updateError") as string);
    } finally {
      loader.hide();
    }
  }

  public async createCaster() {
    this.casterErrors = { ...this.casterDefaultParams };
    let loader = this.$loading.show();
    try {
      await this.createCasterAction(this.casterParams);
      this.$toast.success(this.$t("caster.success") as string);
      await this.$router.push({ name: `admin-casters` });
    } catch (e) {
      this.$toast.error(this.$t("caster.error") as string);
      this.casterErrors = e.response.data.errors;
    } finally {
      loader.hide();
    }
  }

  public async mounted() {
    if (this.editMode) {
      const { data: result } = await this.getCasterAction(this.casterId);
      Object.assign(this.casterParams, result);
    }
    await this.getCountriesAction();
  }
}
</script>
