<template>
  <div class="pa-8">
    <v-card-title>
      Add product
    </v-card-title>
    <form @submit.prevent="addProduct" @keydown="form.onKeydown($event)">
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
        :error-messages="form.errors.errors.category"
        :error="form.errors.has('category')"
        label="Category"
      />
      <v-select
        v-model="form.features"
        item-text="name"
        item-value="id"
        :items="allFeatures"
        label="Features"
        attach
        chips
        multiple
      />
      <div v-if="form.features">
        <v-text-field
          v-for="(feature, key) in form.features"
          :key="key"
          v-model="form.featureValues[key]"
          :error-messages="form.errors.errors.features"
          :error="form.errors.has('features')"
          :label="allFeatures.find(el => el.id == feature).name"
        />
        <!-- :name="features[key].value" -->
      </div>
      <v-text-field
        v-model="form.description"
        :error-messages="form.errors.errors.description"
        :error="form.errors.has('description')"
        label="Description"
        name="description"
      />
      <v-text-field
        v-model.number="form.price"
        type="number"
        :error-messages="form.errors.errors.price"
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
          { v: 1, n: 'yes' },
          { v: 0, n: 'no' }
        ]"
        label="In stock"
      />
      <v-file-input
        v-model="form.images"
        multiple
        chips
        accept="image/*"
        label="File input"
        :error-messages="form.errors.errors.images"
        :error="form.errors.has('images')"
        @change="addFiles"
        @click:clear="clearFiles"
      >
        <template #selection="{ file, index }">
          <!-- <v-chip v-if="file.name" > -->
          <v-img
            :src="imagesUrls[index]"
            :alt="file.name"
            contain
            max-height="50"
            max-width="50"
            class="ma-5"
          />
          <!-- </v-chip> -->
        </template>
      </v-file-input>
      <v-btn :loading="form.busy" type="submit">
        {{ $t("register") }}
      </v-btn>
    </form>
  </div>
</template>
<script>
import * as service from "~/services/Products";
import * as productFeatures from "~/services/ProductFeatures";
import * as productCategories from "~/services/ProductCategories";
import Form from "~/plugins/extendedFormFileUpload.js";

export default {
  props: ["allItems"],
  data: () => ({
    form: new Form({
      name: "",
      images: null,
      category: 1,
      description: "",
      price: 0,
      slug: "",
      instock: 0,
      features: null,
      featureValues: []
    }),
    allFeatures: [],
    allCategories: [],
    imagesUrls: []
  }),
  beforeMount() {
    this.initialize();
  },
  methods: {
    async initialize() {
      this.allFeatures = await productFeatures.getAll();
      this.allCategories = await productCategories.getAll();
    },

    addFiles(files) {
      // console.log(file);
      files.forEach(file => {
        this.readFile(file).then(url => {
          this.imagesUrls.push(url);
        });
      });
      // this.readFile(file[0]).then(url => {
      //   this.imagesUrls.push(url);
      // });
    },
    clearFiles() {
      this.imagesUrls = [];
    },
    readFile(file) {
      const reader = new FileReader();
      return new Promise((resolve, reject) => {
        reader.readAsDataURL(file);
        reader.onload = () => {
          resolve(reader);
        };
        reader.onerror = error => reject(error);
      }).then(read => {
        return read.result;
      });
    },
    async addProduct() {
      const data = await service.addItem(this.form);
      this.$emit("baseTab", data);
    }
  }
};
</script>
