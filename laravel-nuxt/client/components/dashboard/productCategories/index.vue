<template>
  <div>
    <v-tabs v-model="tabs" fixed-tabs>
      <v-tabs-slider />
      <v-tab href="#list_product_categories" class="primary--text">
        <v-icon class="text-caption">mdi-format-list-bulleted</v-icon>
      </v-tab>

      <v-tab href="#add_product_categories" class="primary--text">
        <v-icon class="text-caption">mdi-plus-box-multiple-outline</v-icon>
      </v-tab>

      <v-tab href="#edit_product_categories" class="primary--text">
        <v-icon class="text-caption">mdi-file-edit-outline</v-icon>
      </v-tab>
    </v-tabs>
    <v-tabs-items v-model="tabs">
      <v-tab-item value="list_product_categories">
        <v-card flat>
          <v-card-text>1</v-card-text>
        </v-card>
      </v-tab-item>
      <v-tab-item value="add_product_categories">
        <v-card flat>
          <Add @baseTab="baseTab" />
        </v-card>
      </v-tab-item>
      <v-tab-item value="edit_product_categories">
        <v-card flat>
          <v-card-text>3</v-card-text>
        </v-card>
      </v-tab-item>
    </v-tabs-items>
  </div>
</template>
<script>
import Add from "./add";
export default {
  components: {
    Add
  },
  data() {
    return {
      tabs: null
    };
  },
  methods: {
    baseTab() {
      this.tabs = "list_product_categories";
    }
  }
};
</script>
