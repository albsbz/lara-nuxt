<template>
  <v-menu open-on-hover left bottom>
    <template #activator="{ on, attrs }">
      <v-btn icon v-bind="attrs" v-on="on">
        <v-icon small>mdi-earth</v-icon>
        {{ locales[locale] }}
      </v-btn>
    </template>

    <v-list>
      <v-list-item
        v-for="(value, key) in locales"
        :key="key"
        @click.prevent="setLocale(key)"
      >
        <v-list-item-title>
          {{ value }}
        </v-list-item-title>
      </v-list-item>
    </v-list>
  </v-menu>
</template>

<script>
import { mapGetters } from "vuex";
import { loadMessages } from "~/plugins/i18n";

export default {
  computed: mapGetters({
    locale: "lang/locale",
    locales: "lang/locales"
  }),

  methods: {
    setLocale(locale) {
      if (this.$i18n.locale !== locale) {
        loadMessages(locale);

        this.$store.dispatch("lang/setLocale", { locale });
      }
    }
  }
};
</script>
