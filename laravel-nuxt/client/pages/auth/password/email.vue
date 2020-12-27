<template>
  <v-card class="pa-6">
    <v-card-title>
      {{ $t("reset_password") }}
    </v-card-title>
    <form @submit.prevent="send" @keydown="form.onKeydown($event)">
      <alert-success :form="form" :message="status" />

      <!-- Email -->

      <v-text-field
        v-model="form.email"
        type="email"
        name="email"
        :label="$t('email')"
        :error-messages="form.errors.errors.email"
        :error="form.errors.has('email')"
      />

      <!-- Submit Button -->

      <v-btn :loading="form.busy" type="submit">
        {{ $t("send_password_reset_link") }}
      </v-btn>
    </form>
  </v-card>
</template>

<script>
import Form from "vform";

export default {
  layout: "simple",
  data: () => ({
    status: "",
    form: new Form({
      email: ""
    })
  }),

  head() {
    return { title: this.$t("reset_password") };
  },

  methods: {
    send() {
      this.form.post("/password/email").then(({ data }) => {
        this.status = data.status;
        this.form.reset();
      });
    }
  }
};
</script>
