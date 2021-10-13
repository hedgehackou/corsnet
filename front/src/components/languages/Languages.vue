<template>
  <app-dropdown>
    <template v-slot:dropdown-button>
      <i class="flag-icon" :class="flagIcon"></i>
    </template>
    <template v-slot:dropdown-menu>
      <a
        class="dropdown-item"
        :class="{ active: selectedLanguage === language.key }"
        @click="changeLanguage(language.key)"
        v-for="(language, index) in languages"
        :key="index"
      >
        <i class="flag-icon mr-2" :class="language.flag"></i>
        {{ $t(language.label) }}
      </a>
    </template>
  </app-dropdown>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import Dropdown from "@/components/dropdown/Dropdown.vue";

@Component({
  name: "languages-dropdown",
  components: {
    "app-dropdown": Dropdown,
  },
})
export default class Languages extends Vue {
  public selectedLanguage: string | null = null;
  public languages: any = [
    {
      key: "en",
      flag: "flag-icon-us",
      label: "languages.english",
    },
    {
      key: "ru",
      flag: "flag-icon-ru",
      label: "languages.russian",
    },
  ];

  public mounted() {
    this.selectedLanguage = this.$i18n.locale;
  }

  get flagIcon() {
    if (this.selectedLanguage === "ru") {
      return "flag-icon-de";
    }
    return "flag-icon-us";
  }

  public changeLanguage(langCode: string) {
    if (this.$i18n.locale !== langCode) {
      this.$i18n.locale = langCode;
      this.selectedLanguage = langCode;
    }
  }
}
</script>

<style lang="scss">
.dropdown-item {
  cursor: pointer;
}
</style>
