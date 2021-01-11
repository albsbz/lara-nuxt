<template>
  <div>
    <v-tabs v-model="tabs" fixed-tabs>
      <v-tabs-slider />
      <v-tab href="#list_product_features" class="primary--text">
        <v-icon class="text-caption">
          mdi-format-list-bulleted
        </v-icon>
      </v-tab>

      <v-tab href="#add_product_features" class="primary--text">
        <v-icon class="text-caption">
          mdi-plus-box-multiple-outline
        </v-icon>
      </v-tab>
    </v-tabs>
    <v-tabs-items v-model="tabs">
      <v-tab-item value="list_product_features">
        <v-card flat>
          <All
            :all-items="allItems"
            @deleteItem="deleteItem"
            @baseTab="baseTab"
          />
        </v-card>
      </v-tab-item>
      <v-tab-item value="add_product_features">
        <v-card flat>
          <Add :all-items="allItems" @baseTab="baseTab" />
        </v-card>
      </v-tab-item>
    </v-tabs-items>
  </div>
</template>
<script>
import Add from "./add";
import All from "./all";
import * as service from "~/services/ProductFeatures";
export default {
  components: {
    Add,
    All
  },
  data() {
    return {
      tabs: null,
      allItems: []
    };
  },
  beforeMount() {
    this.initialize();
  },
  methods: {
    async initialize() {
      this.allItems = await service.getAll();
    },
    baseTab(data) {
      if (this.tabs != "list_product_features") {
        this.tabs = "list_product_features";
      }
      this.allItems = data;
    },
    async deleteItem(id) {
      this.allItems = await service.deleteItem(id);
    }
  }
};
</script>
