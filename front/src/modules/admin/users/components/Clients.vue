<template>
  <section class="content">
    <div class="container-fluid overflow-hidden">
      <div class="mount-point-card-wrapper">
        <b-card
          v-for="(client, index) in clients"
          :key="index"
          no-body
          class="mb-1 mt-4"
        >
          <b-card-header header-tag="header" class="p-1" role="tab">
            <b-button
              @click.prevent="client.isShow = !client.isShow"
              block
              variant="info"
              class="d-flex align-items-center"
            >
              <div class="d-flex align-items-center">
                <div class="fa fa-minus" v-if="client.isShow"></div>
                <div class="fa fa-plus" v-else></div>
                <div class="ml-2">
                  {{ client.name }}
                </div>
              </div>
              <b-btn
                v-if="client.id && role === 'admin'"
                @click.prevent.stop="client.disabled = !client.disabled"
                class="ml-auto"
                size="sm"
                variant="primary"
                ><i class="fa fa-pencil-alt"></i
              ></b-btn>
              <b-btn
                v-if="role === 'admin'"
                @click.prevent.stop="removeClient(client)"
                :class="client.id ? 'ml-2' : 'ml-auto'"
                size="sm"
                variant="danger"
                ><i class="fa fa-trash"></i
              ></b-btn>
            </b-button>
          </b-card-header>
          <b-collapse v-model="client.isShow">
            <b-card-body>
              <div>{{ $t("client.name") }}</div>
              <b-input
                size="sm"
                v-model="client.name"
                :disabled="client.disabled"
              />
              <form-error-list-printer
                :error-list="
                  clientErrors[index] ? clientErrors[index].name : []
                "
              />
              <div class="mt-3">{{ $t("client.userName") }}</div>
              <b-input
                size="sm"
                class=""
                :disabled="client.disabled"
                v-model="client.user_name"
              />
              <form-error-list-printer
                :error-list="
                  clientErrors[index] ? clientErrors[index].user_name : []
                "
              />
              <div class="mt-3">{{ $t("client.password") }}</div>
              <b-input
                type="password"
                size="sm"
                :disabled="client.disabled"
                class=""
                v-model="client.password"
              />
              <form-error-list-printer
                :error-list="
                  clientErrors[index] ? clientErrors[index].password : []
                "
              />
              <div class="mt-3">{{ $t("client.ntripVersion") }}</div>
              <b-select
                :disabled="client.disabled"
                :options="ntripVersions"
                v-model="client.ntrip_version"
              ></b-select>
              <form-error-list-printer
                :error-list="
                  clientErrors[index] ? clientErrors[index].ntrip_version : []
                "
              />
              <div class="mt-3">{{ $t("client.isEncrypted") }}</div>
              <b-check
                :disabled="client.disabled"
                v-model="client.is_encrypted"
                size="sm"
                class=""
              />
              <form-error-list-printer
                :error-list="
                  clientErrors[index] ? clientErrors[index].is_encrypted : []
                "
              />
              <div class="d-flex">
                <b-btn
                  v-if="!client.disabled && role === 'admin'"
                  size="sm"
                  @click="saveClient(client, index)"
                  variant="primary"
                  class="mt-3 ml-auto"
                  >{{ $t("index.save") }}</b-btn
                >
              </div>
            </b-card-body>
          </b-collapse>
        </b-card>
      </div>
      <b-btn
        v-if="role === 'admin'"
        @click="addClient"
        variant="primary"
        class="mt-3 mb-3"
        >{{ $t("client.addClient") }}</b-btn
      >
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import FormErrorListPrinter from "@/components/form/FormErrorListPrinter.vue";
import { namespace } from "vuex-class";
import StoreModule from "@/store/StoreModule";

import { UserStoreModule } from "@/modules/admin/users/store/UsersStore";

const authStore = namespace("AuthStoreModule");
const usersStore = namespace("UserStoreModule");
StoreModule.registerMany({
  UserStoreModule,
});

@Component({
  components: {
    FormErrorListPrinter,
  },
})
export default class Clients extends Vue {
  public clients: any = [];
  public clientErrors: any = {};
  public ntripVersions = [
    { text: "1", value: "1" },
    { text: "2", value: "2" },
    { text: this.$t("client.universal"), value: "universal" },
  ];

  public clientDefaultParams = {
    disabled: false,
    isShow: true,
    name: null,
    user_name: null,
    password: null,
    ntrip_version: "1",
    is_encrypted: false,
  };

  @authStore.Getter("getRole")
  public role!: string;

  @usersStore.Action("deleteClient")
  deleteClientAction!: (payload: any) => Promise<any>;

  @usersStore.Action("createClient")
  createClientAction!: (receiver: any) => Promise<any>;

  @usersStore.Action("updateClient")
  updateClientAction!: (antenna: any) => Promise<any>;

  @usersStore.Action("getClients")
  getClientsAction!: (antenna: any) => Promise<any>;

  async removeClient(client: any) {
    this.$bvModal
      .msgBoxConfirm(this.$t("client.deleteClient") as string, {
        title: this.$t("index.confirm") as string,
        size: "sm",
        buttonSize: "sm",
        okVariant: "danger",
        okTitle: this.$t("index.yes") as string,
        cancelTitle: this.$t("index.no") as string,
        footerClass: "p-2",
        hideHeaderClose: false,
        centered: true,
      })
      .then(async (value) => {
        if (value) {
          let loader = this.$loading.show();
          try {
            if (client.id) {
              await this.deleteClientAction({
                id: client.id,
                userId: this.$route.params.userId,
              });
            }
            this.clients.splice(this.clients.indexOf(client), 1);
          } finally {
            loader.hide();
          }
        }
      });
  }

  public async saveClient(client: any, index: number) {
    let loader = this.$loading.show();
    try {
      this.$set(this.clientErrors, index, {});
      client.userId = this.$route.params.userId;
      if (client.id) {
        await this.updateClientAction(client);
      } else {
        let { data } = await this.createClientAction(client);
        client.id = data.data.id;
        client.disabled = true;
      }
      this.$toast.success(this.$t("client.savedSuccessfully") as string);
    } catch (e) {
      this.$toast.error(this.$t("client.error") as string);
      this.$set(this.clientErrors, index, e.response.data.errors);
    } finally {
      loader.hide();
    }
  }

  public async addClient() {
    this.clients.push(Object.assign({}, this.clientDefaultParams));
  }

  mounted() {
    this.getClientsAction(this.$route.params.userId).then(({ data }) => {
      this.clients = data.list || [];
    });
  }
}
</script>

<style lang="scss">
.mount-point-card-wrapper {
  max-width: 800px;
}
</style>
