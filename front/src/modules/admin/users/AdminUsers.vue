<template>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <b-table
            class="mt-4 invite-table"
            responsive
            hover
            show-empty
            :items="getInviteList"
            :fields="getInviteTableFields"
          >
            <template #empty="">
              <h4>{{ $t("users.emptyTable") }}</h4>
            </template>
            <template #head(is_admin)="">
              {{ $t("users.role") }}
            </template>
            <template #cell(is_admin)="{ item }">
              {{ item.is_admin ? $t("users.admin") : $t("users.user") }}
            </template>
          </b-table>
          <b-pagination
            class="ml-auto mt-1 mb-0"
            :value="getCurrentPage"
            @change="changePage"
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
import { UserStoreModule } from "@/modules/admin/users/store/UsersStore";

const inviteStore = namespace("UserStoreModule");
StoreModule.registerMany({
  UserStoreModule,
});

@Component({
  components: {
    FormErrorListPrinter,
  },
})
export default class AdminUsers extends Vue {
  public roles = [
    { title: this.$t("users.admin"), value: "admin" },
    { title: this.$t("users.user"), value: "user" },
  ];

  @inviteStore.Getter("getUserList")
  public getInviteList!: any[];

  @inviteStore.Getter("getTotal")
  public getTotal!: any[];

  @inviteStore.Getter("getPerPage")
  public getPerPage!: any[];

  @inviteStore.Getter("getCurrentPage")
  public getCurrentPage!: any[];

  @inviteStore.Action("getUserList")
  getUserListAction!: (payload: any) => Promise<any>;

  public get getInviteTableFields() {
    return [{ key: "id" }, { key: "is_admin" }, { key: "email" }];
  }

  public changePage(page = 1) {
    this.getUserListAction({ page });
  }

  async mounted() {
    this.getUserListAction({});
  }
}
</script>

<style scoped>
.invite-table {
  background-color: #fff;
}
</style>
