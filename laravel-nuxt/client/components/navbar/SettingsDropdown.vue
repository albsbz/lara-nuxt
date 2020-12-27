<template>
  <v-menu open-on-hover left bottom>
    <template #activator="{ on, attrs }">
      <v-btn icon v-bind="attrs" v-on="on">
        <v-icon large>mdi-account</v-icon>
      </v-btn>
    </template>

    <v-list>
      <template v-if="authenticated">
        <v-list-item :to="{ name: 'home' }">
          <v-list-item-title>
            {{ $t("home") }}
          </v-list-item-title>
        </v-list-item>
        <v-list-item :to="{ name: 'settings.profile' }">
          <v-list-item-title>
            {{ $t("settings") }}
          </v-list-item-title>
        </v-list-item>
        <v-list-item @click.prevent="logout">
          <v-list-item-title>
            {{ $t("logout") }}
          </v-list-item-title>
        </v-list-item>
      </template>

      <template v-else>
        <v-list-item :to="{ name: 'login' }">
          <v-list-item-title>
            {{ $t("login") }}
          </v-list-item-title>
        </v-list-item>
        <v-list-item :to="{ name: 'register' }">
          <v-list-item-title>
            {{ $t("register") }}
          </v-list-item-title>
        </v-list-item>
      </template>
    </v-list>
  </v-menu>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  computed: mapGetters({
    authenticated: "auth/check"
  }),
  methods: {
    async logout() {
      // Log out the user.
      await this.$store.dispatch("auth/logout");

      // Redirect to login.
      this.$router.push({ name: "login" });
    }
  }
};
</script>
