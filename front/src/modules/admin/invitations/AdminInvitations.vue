<template>
  <section class="content">
    <b-modal
      centered
      v-model="isShowCreateInviteModal"
      :title="$t('invite.createInvite')"
      :ok-title="$t('invite.create')"
      :cancel-title="$t('invite.cancel')"
      @hidden="inviteModalHidden"
      @ok.prevent="createInvite"
    >
      <strong class="mt-2">Email</strong>
      <b-form-input
        class="mt-1"
        v-model="inviteParams.email"
        type="text"
      ></b-form-input>
      <form-error-list-printer :error-list="inviteParamsErrors.email" />

      <div>
        <strong class="mt-2">{{ $t("invite.role") }}</strong>
        <b-form-select
          class="mt-1"
          value-field="value"
          text-field="title"
          :options="roles"
          v-model="inviteParams.role"
          type="text"
        ></b-form-select>
        <form-error-list-printer :error-list="inviteParamsErrors.role" />
      </div>
    </b-modal>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <b-button @click="openInviteModal" class="mt-4" variant="primary">{{
            $t("invite.createInvite")
          }}</b-button>
        </div>
        <div class="col-12">
          <b-table
            class="mt-4 invite-table"
            responsive
            hover
            show-empty
            :items="getInviteList"
            :fields="getInviteTableFields"
            :empty-text="$t('devices.empty_val')"
          >
            <template #empty="">
              <h4>{{ $t("invite.emptyTable") }}</h4>
            </template>
            <template #head(is_admin)="">
              {{ $t("invite.role") }}
            </template>
            <template #head(is_accepted)="">
              {{ $t("invite.inviteAccepted") }}
            </template>
            <template #head(actions)="">
              {{ $t("invite.actions") }}
            </template>
            <template #cell(is_admin)="{ item }">
              {{ item.is_admin ? $t("invite.admin") : $t("invite.user") }}
            </template>
            <template #cell(is_accepted)="{ item }">
              <div v-if="item.is_accepted" class="text-success">
                {{ $t("invite.yes") }}
              </div>
              <div v-else class="text-danger">
                {{ $t("invite.no") }}
              </div>
            </template>
            <template #cell(actions)="{ item }">
              <b-btn variant="danger" @click="openDeleteModal(item.id)">
                <div class="fa fa-trash"></div>
              </b-btn>
            </template>
          </b-table>
          <b-pagination
            class="ml-auto mt-1 mb-0"
            @change="changePage"
            :value="getCurrentPage"
            :total-rows="getTotal"
            :per-page="getPerPage"
          ></b-pagination>
        </div>
      </div>
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import FormErrorListPrinter from "@/components/form/FormErrorListPrinter.vue";
import { namespace } from "vuex-class";
import StoreModule from "@/store/StoreModule";
import { InviteStoreModule } from "@/modules/admin/invitations/store/InviteStore";

const inviteStore = namespace("InviteStoreModule");
StoreModule.registerMany({
  InviteStoreModule,
});

@Component({
  components: {
    FormErrorListPrinter,
  },
})
export default class AdminInvitations extends Vue {
  public isShowCreateInviteModal = false;
  public roles = [
    { title: this.$t("invite.admin"), value: "admin" },
    { title: this.$t("invite.user"), value: "user" },
  ];

  public inviteDefaultParams = { email: null, role: null };
  public inviteParams = { ...this.inviteDefaultParams };
  public inviteParamsErrors = { ...this.inviteDefaultParams };

  public inviteModalHidden() {
    this.inviteParams = { ...this.inviteDefaultParams };
    this.inviteParamsErrors = { ...this.inviteDefaultParams };
  }

  @inviteStore.Getter("getInviteList")
  public getInviteList!: any[];

  @inviteStore.Getter("getTotal")
  public getTotal!: any[];

  @inviteStore.Getter("getPerPage")
  public getPerPage!: any[];

  @inviteStore.Getter("getCurrentPage")
  public getCurrentPage!: any[];

  @inviteStore.Action("getInviteList")
  getInviteListAction!: (payload: any) => Promise<any>;

  @inviteStore.Action("createInvite")
  createInviteAction!: (payload: any) => Promise<any>;

  @inviteStore.Action("deleteInvite")
  deleteInviteAction!: (payload: any) => Promise<any>;

  public openInviteModal() {
    this.isShowCreateInviteModal = true;
  }

  public get getInviteTableFields() {
    return [
      { key: "id" },
      { key: "is_admin" },
      { key: "email" },
      { key: "is_accepted" },
      { key: "actions" },
    ];
  }

  public openDeleteModal(id: number) {
    this.$bvModal
      .msgBoxConfirm(this.$t("invite.deleteInvite") as string, {
        title: this.$t("invite.confirm") as string,
        size: "sm",
        buttonSize: "sm",
        okVariant: "danger",
        okTitle: this.$t("invite.yes") as string,
        cancelTitle: this.$t("invite.no") as string,
        footerClass: "p-2",
        hideHeaderClose: false,
        centered: true,
      })
      .then(async (value) => {
        if (value) {
          let loader = this.$loading.show();
          try {
            await this.deleteInviteAction(id);
            await this.getInviteListAction({});
          } finally {
            loader.hide();
          }
        }
      });
  }

  public async createInvite() {
    this.inviteParamsErrors = { ...this.inviteDefaultParams };
    let loader = this.$loading.show();
    try {
      await this.createInviteAction(this.inviteParams);
      this.isShowCreateInviteModal = false;
      this.$toast.success(this.$t("invite.success") as string);
      await this.getInviteListAction({});
    } catch (e) {
      this.$toast.error(this.$t("invite.error") as string);
      this.inviteParamsErrors = e.response.data.errors;
    } finally {
      loader.hide();
    }
  }

  public changePage(page = 1) {
    this.getInviteListAction({ page });
  }

  async mounted() {
    this.getInviteListAction({});
  }
}
</script>

<style scoped>
.invite-table {
  background-color: #fff;
}
</style>
