<template>
  <div>
    <v-tabs v-model="tabs" fixed-tabs>
      <v-tabs-slider />
      <v-tab href="#list_products" class="primary--text">
        <v-icon class="text-caption">
          mdi-format-list-bulleted
        </v-icon>
      </v-tab>

      <v-tab href="#add_products" class="primary--text">
        <v-icon class="text-caption">
          mdi-plus-box-multiple-outline
        </v-icon>
      </v-tab>
    </v-tabs>
    <v-tabs-items v-model="tabs">
      <v-tab-item value="list_products">
        <v-card flat>
          <All
            :all-items="allItems"
            @deleteItem="deleteItem"
            @baseTab="baseTab"
          />
        </v-card>
      </v-tab-item>
      <v-tab-item value="add_products">
        <v-card flat>
          <Add :all-items="allItems" @baseTab="baseTab" />
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
  beforeMount() {
    this.initialize();
  },
  methods: {
    async initialize() {
      try {
        const { data } = await axios.get("/dashboard/product/all");
        this.allItems = data; // if pagination needed
      } catch (e) {
        console.log(e);
      }
    },
    baseTab(data) {
      if (this.tabs != "list_products") {
        this.tabs = "list_products";
      }
      this.allItems = data;
    },
    async deleteItem(id) {
      try {
        const { data } = await axios.delete("/dashboard/product/", {
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
