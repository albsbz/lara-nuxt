<template>
  <div>
    <v-card v-if="mustVerifyEmail" class="pa-6 app-card">
      <v-card offset="4">
        {{ $t("register") }}
      </v-card>
      <div class="alert alert-success" role="alert">
        {{ $t("verify_email_address") }}
      </div>
    </v-card>
    <v-card v-else class="pa-6">
      <v-card-title>
        {{ $t("register") }}
      </v-card-title>
      <form @submit.prevent="register" @keydown="form.onKeydown($event)">
        <!-- Name -->

        <v-text-field
          v-model="form.name"
          :error-messages="form.errors.errors.name"
          :error="form.errors.has('name')"
          :label="$t('name')"
          name="name"
        />

        <!-- Email -->
        <v-text-field
          v-model="form.email"
          :error-messages="form.errors.errors.email"
          :error="form.errors.has('email')"
          :label="$t('email')"
          type="email"
          name="email"
        />

        <!-- <has-error :form="form" field="email" /> -->

        <!-- Password -->
        <v-text-field
          v-model="form.password"
          :error-messages="form.errors.errors.password"
          :error="form.errors.has('password')"
          :label="$t('password')"
          type="password"
          name="password"
        />

        <!-- Password Confirmation -->
        <v-text-field
          v-model="form.password_confirmation"
          :error-messages="form.errors.errors.password_confirmation"
          :error="form.errors.has('password_confirmation')"
          :label="$t('confirm_password')"
          type="password"
          name="password_confirmation"
        />

        <!-- Submit Button -->
        <v-btn :loading="form.busy" type="submit">
          {{ $t("register") }}
        </v-btn>

        <!-- GitHub Login Button -->
        <login-with-github />
      </form>
    </v-card>
  </div>
</template>

<script>
import Form from "vform";

export default {
  layout: "simple",
  middleware: "guest",

  data: () => ({
    form: new Form({
      name: "",
      email: "",
      password: "",
      password_confirmation: ""
    }),
    mustVerifyEmail: false
  }),

  head() {
    return { title: this.$t("register") };
  },

  methods: {
    async register() {
      let data;

      // Register the user.
      try {
        const response = await this.form.post("/register");
        data = response.data;
      } catch (e) {
        return;
      }

      // Must verify email fist.
      if (data.status) {
        this.mustVerifyEmail = true;
      } else {
        // Log in the user.
        const {
          data: { token }
        } = await this.form.post("/login");

        // Save the token.
        this.$store.dispatch("auth/saveToken", { token });

        // Update the user.
        await this.$store.dispatch("auth/updateUser", { user: data });

        // Redirect home.
        this.$router.push({ name: "home" });
      }
    }
  }
};
</script>
<style scoped>
.app-card {
  min-height: 100%;
}
</style>
