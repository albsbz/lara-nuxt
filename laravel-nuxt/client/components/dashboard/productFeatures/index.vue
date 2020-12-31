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
            :allItems="allItems"
            @deleteItem="deleteItem"
            @baseTab="baseTab"
          />
        </v-card>
      </v-tab-item>
      <v-tab-item value="add_product_features">
        <v-card flat>
          <Add :allItems="allItems" @baseTab="baseTab" />
        </v-card>
      </v-tab-item>
    </v-tabs-items>
  </div>
</template>
<script>
import axios from "axios";
import Add from "./add";
import All from "./all";
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
  created() {
    this.initialize();
  },
  methods: {
    async initialize() {
      try {
        const { data } = await axios.get("/dashboard/product-feature/all");
        this.allItems = data; // if pagination needed
      } catch (e) {
        console.log(e);
      }
    },
    baseTab(data) {
      if (this.tabs != "list_product_features") {
        this.tabs = "list_product_features";
      }
      this.allItems = data;
    },
    async deleteItem(id) {
      try {
        const { data } = await axios.delete("/dashboard/product-feature/", {
          data: { id }
        });
        this.allItems = data; // if pagination needed
      } catch (e) {
        console.log(e);
      }
    }
  }
};
</script>
