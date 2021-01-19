<template>
  <v-app-bar app color="white" flat>
    <v-tabs centered class="ml-n9" color="grey darken-1">
      <v-tab v-for="(link, title) in links" :key="title" :to="{ name: link }">
        {{ title }}
      </v-tab>
    </v-tabs>

    <LocaleDropdown />
    <SettingsDropdown />
  </v-app-bar>
</template>

<script>
import { mapGetters } from "vuex";
import LocaleDropdown from "./LocaleDropdown.vue";
import SettingsDropdown from "./SettingsDropdown.vue";

export default {
  components: {
    LocaleDropdown,
    SettingsDropdown
  },
  data: () => ({
    linksData: {
      Home: "welcome",
      Catalog: "catalog"
    }
  }),
  computed: {
    ...mapGetters({
      roles: "auth/roles"
    }),
    links() {
      let newLinks = this.linksData;
      if (this.roles.includes("admin")) {
        newLinks = { ...newLinks, ...{ Dashboard: "dashboard.index" } };
      }
      return newLinks;
    }
  }
};
</script>
