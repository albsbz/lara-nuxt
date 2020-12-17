<template>
  <div>
    <div class="text-center">
      <v-btn dark color="red darken-2" @click="snackbar = true">
        Open Snackbar
      </v-btn>

      <v-snackbar v-model="snackbar" :multi-line="multiLine">
        {{ text }}

        <template v-slot:action="{ attrs }">
          <v-btn color="red" text v-bind="attrs" @click="snackbar = false">
            Close
          </v-btn>
        </template>
      </v-snackbar>
    </div>
    <div class="top-right links">
      <template v-if="authenticated">
        <router-link :to="{ name: 'home' }">
          {{ $t("home") }}
        </router-link>
      </template>
      <template v-else>
        <router-link :to="{ name: 'login' }">
          {{ $t("login") }}
        </router-link>
        <router-link :to="{ name: 'register' }">
          {{ $t("register") }}
        </router-link>
      </template>
    </div>

    <div class="text-center">
      <div class="title mb-4">
        <span class="laravel">Laravel</span><span class="nuxt">Nuxt</span>
        <!-- {{ title }} -->
      </div>

      <div class="links">
        <a href="https://github.com/cretueusebiu/laravel-nuxt"
          >github.com/cretueusebiu/laravel-nuxt</a
        >
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  layout: "simple",

  data: () => ({
    title: process.env.appName,
    multiLine: true,
    snackbar: false,
    text: `I'm a multi-line snackbar.`
  }),

  head() {
    return { title: this.$t("home") };
  },

  computed: mapGetters({
    authenticated: "auth/check"
  })
};
</script>

<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}

.title {
  font-size: 85px;
}

.laravel {
  color: #2e495e;
}

.nuxt {
  color: #00c48d;
}
</style>
