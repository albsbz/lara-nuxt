<template>
  <div class="pa-8">
    <v-card-title>
      Add product feature
    </v-card-title>
    <form @submit.prevent="addFeature" @keydown="form.onKeydown($event)">
      <!-- Name -->

      <v-text-field
        v-model="form.name"
        :error-messages="form.errors.errors.name"
        :error="form.errors.has('name')"
        :label="$t('name')"
        name="name"
      />

      <v-btn :loading="form.busy" type="submit">
        {{ $t("register") }}
      </v-btn>
    </form>
  </div>
</template>
<script>
import Form from "vform";
import * as service from "~/services/ProductFeatures";
export default {
  props: ["allItems"],
  data: () => ({
    form: new Form({
      name: ""
    })
  }),

  methods: {
    async addFeature() {
      const data = await service.addItem(this.form);
      this.$emit("baseTab", data);
    }
  }
};
</script>
