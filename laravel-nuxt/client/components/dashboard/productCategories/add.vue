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
      <v-btn :loading="form.busy" type="submit">
        {{ $t("register") }}
      </v-btn>
    </form>
  </div>
</template>
<script>
import Form from "vform";

export default {
  data: () => ({
    form: new Form({
      parent_id: 0,
      name: "",
      description: "",
      slug: ""
    })
  }),

  methods: {
    async addCategory() {
      let data;

      try {
        // const response = await this.form.post("/add/product-category");
        // data = response.data;
      } catch (e) {
        return;
      }

      // Redirect home.
      // this.$router.push({
      //   path: "/dashboard",
      //   hash: "#list_product_categories"
      // });
      this.$emit("baseTab");
    }
  }
};
</script>
