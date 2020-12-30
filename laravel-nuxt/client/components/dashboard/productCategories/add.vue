<template>
  <div class="pa-8">
    <v-card-title>
      Add product category
    </v-card-title>
    <form @submit.prevent="addCategory" @keydown="form.onKeydown($event)">
      <!-- Name -->

      <v-text-field
        v-model="form.name"
        :error-messages="form.errors.errors.name"
        :error="form.errors.has('name')"
        :label="$t('name')"
        name="name"
      />
      <v-text-field
        v-model="form.description"
        :error-messages="form.errors.errors.description"
        :error="form.errors.has('description')"
        label="Description"
        name="description"
      />
      <v-text-field
        v-model="form.slug"
        :error-messages="form.errors.errors.slug"
        :error="form.errors.has('slug')"
        label="Slug"
        name="slug"
      />
      <v-select
        v-model="form.parent_id"
        item-value="id"
        item-text="name"
        :items="allItems"
        label="Parent category"
      />
      <v-btn :loading="form.busy" type="submit">
        {{ $t("register") }}
      </v-btn>
    </form>
  </div>
</template>
<script>
import Form from "vform";

export default {
  props: ["allItems"],
  data: () => ({
    form: new Form({
      parent_id: 1,
      name: "",
      description: "",
      slug: ""
    })
  }),

  methods: {
    async addCategory() {
      let data;

      try {
        const { data } = await this.form.post("dashboard/product-category/add");
        // data = response.data
        this.$emit("baseTab", data);
      } catch (e) {
        return;
      }
    }
  }
};
</script>
