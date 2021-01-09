<template>
  <v-app id="inspire">
    <app-navbar />
    <v-main class="grey lighten-3">
      <v-container>
        <v-row>
          <!-- <v-col cols="12" sm="2">
            <v-sheet rounded="lg" min-height="268">
              -->
          <!-- </v-sheet>
          </v-col> -->

          <v-col cols="12" sm="12">
            <v-sheet min-height="70vh" rounded="lg">
              <nuxt />
            </v-sheet>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
    <v-footer color="primary lighten-1" padless>
      <v-row justify="center" no-gutters>
        <v-btn
          v-for="link in footerLinks"
          :key="link"
          color="white"
          text
          rounded
          class="my-2"
        >
          {{ link }}
        </v-btn>
        <v-col class="primary lighten-2 py-4 text-center white--text" cols="12">
          <strong>Vuetify</strong>
        </v-col>
      </v-row>
    </v-footer>
  </v-app>
</template>

<script>
import AppNavbar from "../components/navbar/NavbarMain";

export default {
  components: {
    AppNavbar
  },
  data: () => ({
    footerLinks: ["Home", "About Us", "Team", "Services", "Blog", "Contact Us"]
  })
};
</script>

<style lang="scss"></style>
