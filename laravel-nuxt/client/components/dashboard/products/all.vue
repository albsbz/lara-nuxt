<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="allItems"
      sort-by="id"
      class="elevation-1"
    >
      <template #item.images="{ item }">
        <div v-if="item.images" class="p-2">
          <v-img
            :src="firstImage(item)"
            :alt="item.name"
            max-height="50px"
            max-width="50px"
          />
        </div>
      </template>
      <template #item.features="{ item }">
        <div v-if="item.features" class="p-2">
          <p>{{ featureToShow(item) }}</p>
        </div>
      </template>

      <template #top>
        <v-toolbar flat>
          <v-toolbar-title>Products</v-toolbar-title>
          <v-spacer />
          <v-dialog v-model="dialog" max-width="800px">
            <v-card>
              <form
                id="save"
                @keydown="form.onKeydown($event)"
                @submit.prevent="save"
              />
              <v-card-title>
                Products
              </v-card-title>

              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="12" md="12">
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
                        :error-messages="form.errors.errors.category"
                        :error="form.errors.has('category')"
                        :items="allCategories"
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
                          v-model="form.featureValues[feature]"
                          :error-messages="form.errors.errors.features"
                          :error="form.errors.has('features')"
                          :label="allFeatures.find(el => el.id == feature).name"
                        />
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
                      <app-product-gallery
                        v-model="imagesSequence"
                        @clearUploadField="clearUploadField"
                      />

                      <v-file-input
                        v-model="preUploadImages"
                        multiple
                        chips
                        accept="image/*"
                        label="File input"
                        :error-messages="form.errors.errors.images"
                        :error="form.errors.has('images')"
                        @change="addFiles"
                        @click:clear="clearUpload"
                      >
                        <template #selection="{ file, index }">
                          <v-img
                            :src="preUploadImagesUrls[index]"
                            :alt="file.name"
                            contain
                            max-height="50"
                            max-width="50"
                            class="ma-5"
                          />
                        </template>
                      </v-file-input>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>

              <v-card-actions>
                <v-spacer />
                <v-btn color="blue darken-1" text @click="close">
                  Cancel
                </v-btn>
                <v-btn color="blue darken-1" text type="submit" form="save">
                  Save
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
          <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="headline">
                Are you sure you want to delete this item?
              </v-card-title>
              <v-card-actions>
                <v-spacer />
                <v-btn color="blue darken-1" text @click="closeDelete">
                  Cancel
                </v-btn>
                <v-btn color="blue darken-1" text @click="deleteItemConfirm">
                  OK
                </v-btn>
                <v-spacer />
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template #item.actions="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)">
          mdi-pencil
        </v-icon>
        <v-icon small @click="deleteItem(item)">
          mdi-delete
        </v-icon>
      </template>
      <template #no-data>
        <v-btn color="primary">
          Reset
        </v-btn>
      </template>
    </v-data-table>
  </div>
</template>
<script>
import axios from "axios";
import Form from "~/plugins/extendedFormFileUpload.js";
import appProductGallery from "~/components/global/ProductGallery";

export default {
  components: {
    appProductGallery
  },
  props: ["allItems"],
  data: () => ({
    env: process.env.serverUrl,
    dialog: false,
    dialogDelete: false,
    headers: [
      { text: "ID", align: "start", value: "id" },
      { text: "Name", value: "name" },
      { text: "Category", value: "category.name" },
      { text: "Description", value: "description" },
      { text: "Price", value: "price" },
      { text: "Slug", value: "slug" },
      { text: "Instock", value: "instock" },
      { text: "Image", value: "images" },
      { text: "Feature", value: "features" },
      { text: "Actions", value: "actions", sortable: false }
    ],

    editedIndex: -1,
    form: new Form({
      name: "",
      images: [],
      category: 1,
      description: "",
      price: 0,
      slug: "",
      instock: 0,
      features: [],
      featureValues: [],
      imagesSequence: [],
      newImages: []
    }),
    defaultItem: {
      name: "",
      images: [],
      category: 1,
      description: "",
      price: 0,
      slug: "",
      instock: 0,
      features: [],
      featureValues: [],
      imagesSequence: [],
      newImages: []
    },
    preUploadImages: [],
    preUploadImagesUrls: [],
    imagesSequence: [],
    allFeatures: [],
    allCategories: [],
    overlay: false
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    }
  },
  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    }
  },
  created() {
    this.initialize();
  },

  methods: {
    firstImage(item) {
      if (item.images[0]) {
        return this.env + item.images[0].url;
      }
    },
    featureToShow(item) {
      return item.features.reduce((res, feature) => {
        return `${feature.name}, ${res}`;
      }, "");
    },
    async initialize() {
      try {
        this.allFeatures = await (
          await axios.get("/dashboard/product-feature/all")
        ).data;
        this.allCategories = await (
          await axios.get("/dashboard/product-category/all")
        ).data;
      } catch (e) {
        console.log(e);
      }
    },

    async editItem(item) {
      await this.initialize();

      this.editedIndex = this.allItems.indexOf(item);
      const newItem = { ...item };
      newItem.featureValues = [];
      item.features.forEach(feature => {
        // debugger;
        newItem.featureValues[feature.id] = feature.pivot.value;
      });
      newItem.features = item.features.map(feature => feature.id);
      this.form = new Form(newItem);
      // this.imagesUrls = this.form.images.map(image => this.env + image.url);
      this.preUploadImages = [];
      this.preUploadImagesUrls = [];

      this.imagesSequence = this.form.images.map(image => ({
        url: image.url,
        id: image.id
      }));
      this.dialog = true;
    },

    deleteItem(item) {
      this.form.id = item.id;
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      this.$emit("deleteItem", this.form.id);
      this.closeDelete();
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        // this.editedItem = Object.assign({}, this.defaultItem);

        this.form = new Form(this.defaultItem);

        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.form = new Form(this.defaultItem);
        this.editedIndex = -1;
      });
    },
    addFiles(files) {
      // console.log(file);
      files.forEach((file, index) => {
        this.readFile(file).then(url => {
          this.preUploadImagesUrls.push(url);
          this.imagesSequence.push({ url, id: null, file });
        });
      });
    },
    clearUpload() {
      this.imagesSequence = this.imagesSequence.filter(obj => obj.id !== null);
      this.clearUploadField();
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

    async save() {
      try {
        this.form.images = [];
        this.form.imagesSequence = [];
        this.form.newImages = [];
        this.imagesSequence.forEach((image, i) => {
          this.form.imagesSequence.push(image.id);
          if (image.id === null) {
            this.form.newImages.push(image.file);
          }
          this.form.images.push(image.url);
        });
        console.log(this.form.newImages);
        const { data } = await this.form.post("dashboard/product/edit");

        this.$emit("baseTab", data);
      } catch (e) {
        console.log(e);
        return;
      }
      this.close();
    },
    clearUploadField() {
      this.preUploadImages = [];
      this.preUploadImagesUrls = [];
    }
  }
};
</script>
