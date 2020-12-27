<template>
  <div>
    <div class="text-center">
      <v-app>
        <v-btn dark color="red darken-2" @click="snackbar = true">
          Open Snackbar
        </v-btn>
      </v-app>

      <v-snackbar v-model="snackbar" :multi-line="multiLine">
        {{ text }}

        <template v-slot:action="{ attrs }">
          <v-btn color="red" text v-bind="attrs" @click="snackbar = false">
            Close
          </v-btn>
        </template>
      </v-snackbar>
    </div>
  </div>
</template>

<script>
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
  }
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
