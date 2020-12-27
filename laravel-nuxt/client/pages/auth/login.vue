<template>
  <v-card class="pa-8">
    <v-card-title>{{ $t("login") }}</v-card-title>
    <form @submit.prevent="login" @keydown="form.onKeydown($event)">
      <!-- Email -->

      <v-text-field
        v-model="form.email"
        type="email"
        name="email"
        class="form-control"
        :label="$t('email')"
        :error-messages="form.errors.errors.email"
        :error="form.errors.has('email')"
      />

      <!-- Password -->
      <v-text-field
        v-model="form.password"
        type="password"
        name="password"
        class="form-control"
        :label="$t('password')"
        :error-messages="form.errors.errors.password"
        :error="form.errors.has('password')"
      />

      <!-- Remember Me -->

      <v-checkbox
        v-model="remember"
        name="remember"
        :label="$t('remember_me')"
      />

      <router-link
        :to="{ name: 'password.request' }"
        class="small ml-auto my-auto"
      >
        {{ $t("forgot_password") }}
      </router-link>
      <br />

      <!-- Submit Button -->
      <v-btn :loading="form.busy" type="submit">
        {{ $t("login") }}
      </v-btn>

      <!-- GitHub Login Button -->
      <login-with-github />
    </form>
  </v-card>
</template>

<script>
import Form from "vform";

export default {
  layout: "simple",
  middleware: "guest",

  data: () => ({
    form: new Form({
      email: "",
      password: ""
    }),
    remember: false
  }),

  head() {
    return { title: this.$t("login") };
  },

  methods: {
    async login() {
      let data;

      // Submit the form.
      try {
        const response = await this.form.post("/login");
        data = response.data;
      } catch (e) {
        return;
      }

      // Save the token.
      this.$store.dispatch("auth/saveToken", {
        token: data.token,
        remember: this.remember
      });

      // Fetch the user.
      await this.$store.dispatch("auth/fetchUser");

      // Redirect home.
      this.$router.push({ name: "welcome" });
    }
  }
};
</script>
