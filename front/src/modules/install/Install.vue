<template>
  <div class="container install">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">
              {{ $t("install.setupDatabase") }}
            </h3>
            <div class="ml-auto"></div>
          </div>
          <div class="d-flex langs">
            <Languages />
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ $t("install.server") }}</label>
                    <input
                      type="email"
                      class="form-control"
                      placeholder="localhost"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ $t("install.databaseName") }}</label>
                    <input class="form-control" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ $t("install.login") }}</label>
                    <input class="form-control" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ $t("install.password") }}</label>
                    <input class="form-control" />
                  </div>
                </div>
              </div>
            </div>

            <div class="card-footer">
              <div class="d-flex">
                <button @click="nextStep" class="btn btn-success ml-auto">
                  {{ $t("install.next") }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import Languages from "@/components/languages/Languages.vue";
import StoreModule from "@/store/StoreModule";
import { InstallStoreModule } from "@/modules/install/store/InstallStore";

StoreModule.registerMany({
  InstallStoreModule,
});

@Component({
  components: {
    Languages,
  },
})
export default class Install extends Vue {
  public FIRST_STEP = 1;
  public SECOND_STEP = 2;
  public THIRD_STEP = 3;

  public appElement: HTMLElement | null = null;
  public currentStep = this.FIRST_STEP;

  public nextStep(): void {
    switch (this.currentStep) {
      case this.FIRST_STEP:
        return;
      case this.SECOND_STEP:
        return;
      case this.THIRD_STEP:
        return;
    }
    this.currentStep += 1;
  }

  public mounted() {
    this.appElement = document.getElementById("app") as HTMLElement;
    this.appElement.classList.add("login-page");
  }

  public unmounted(): void {
    (this.appElement as HTMLElement).classList.remove("login-page");
  }
}
</script>

<style lang="scss">
.install {
  .langs {
    display: flex;
    li {
      margin-left: auto;
      list-style-type: none;
      button {
        border: 1px solid rgba(0, 0, 0, 0.125);
        background: rgba(0, 0, 0, 0.03);
      }
    }
  }
}
</style>
