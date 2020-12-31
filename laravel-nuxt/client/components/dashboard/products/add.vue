<template>
  <div class="pa-8">
    <v-card-title>
      Add product
    </v-card-title>
    <form @submit.prevent="addProduct" @keydown="form.onKeydown($event)">
      <!-- name: "",
      category: 1,
      description: "",
      price:0,
      slug: "",
      instock:false,
      image:[] -->
      <v-text-field
        v-model="form.name"
        :error-messages="form.errors.errors.name"
        :error="form.errors.has('name')"
        :label="$t('name')"
        name="name"
      />
      <v-select
        v-model="form.category"
        item-value="id"
        item-text="name"
        :items="allCategories"
        label="Category"
      />
      <v-text-field
        v-model="form.description"
        :error-messages="form.errors.errors.description"
        :error="form.errors.has('description')"
        label="Description"
        name="description"
      />
      <v-text-field
        v-model="form.price"
        type="number"
        :error-messages="form.errors.errors.description"
        :error="form.errors.has('price')"
        label="price"
        name="price"
      />
      <v-text-field
        v-model="form.slug"
        :error-messages="form.errors.errors.slug"
        :error="form.errors.has('slug')"
        label="Slug"
        name="slug"
      />
      <v-select
        v-model="form.instock"
        item-value="v"
        item-text="n"
        :items="[
          { v: true, n: 'yes' },
          { v: false, n: 'no' }
        ]"
        label="In stock"
      />
      <!-- <v-select
        v-model="form.parent_id"
        item-value="id"
        item-text="name"
        :items="allItems"
        label="Parent category"
      /> -->
      <v-btn :loading="form.busy" type="submit">
        {{ $t("register") }}
      </v-btn>
    </form>
  </div>
</template>
<script>
import Form from "vform";
import axios from "axios";

export default {
  props: ["allItems"],
  data: () => ({
    form: new Form({
      name: "",
      category: 1,
      description: "",
      price: 0,
      slug: "",
      instock: false,
      images: []
    }),
    allFetures: [],
    allCategories: []
  }),
  created() {
    this.initialize();
  },
  methods: {
    async initialize() {
      try {
        this.allFetures = await (
          await axios.get("/dashboard/product-feature/all")
        ).data;
        this.allCategories = await (
          await axios.get("/dashboard/product-category/all")
        ).data;
      } catch (e) {
        console.log(e);
      }
    },
    async addProduct() {
      try {
        const { data } = await this.form.post("dashboard/product/add");
        // data = response.data
        this.$emit("baseTab", data);
      } catch (e) {}
    }
  }
};
</script>
