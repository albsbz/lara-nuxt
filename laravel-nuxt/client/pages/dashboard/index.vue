<template>
  <two-cols>
    <template slot="col-1">
      <v-toolbar flat color="primary" dark>
        <v-toolbar-title>Dashboard</v-toolbar-title>
      </v-toolbar>
      <v-tabs v-model="tab" vertical class="pl-5">
        <v-list-group :value="true" prepend-icon="mdi-shopping">
          <template #activator>
            <v-list-item-title>Products</v-list-item-title>
          </template>

          <v-tab class="text-caption d-flex justify-start" href="#products">
            <v-icon left>
              mdi-access-point
            </v-icon>
            Products
          </v-tab>
          <v-tab
            class="text-caption d-flex justify-start"
            href="#product_categories"
          >
            <v-icon left>
              mdi-folder-outline
            </v-icon>
            Product categories
          </v-tab>
          <v-tab
            class="text-caption d-flex justify-start"
            href="#product_features"
          >
            <v-icon left>
              mdi-lock
            </v-icon>
            Product features
          </v-tab>
        </v-list-group>
        <v-list-group :value="true" prepend-icon="mdi-account">
          <template #activator>
            <v-list-item-title>Users</v-list-item-title>
          </template>
          <v-tab class="text-caption d-flex justify-start" href="#users">
            <v-icon left>
              mdi-access-point
            </v-icon>
            Users
          </v-tab>
        </v-list-group>
      </v-tabs>
    </template>
    <template slot="col-2">
      <v-tabs-items v-model="tab">
        <v-tab-item value="product_categories">
          <v-card flat>
            <ProductCategories />
          </v-card>
        </v-tab-item>
        <v-tab-item value="product_features">
          <v-card flat>
            <ProductFeatures />
          </v-card>
        </v-tab-item>
        <v-tab-item value="products">
          <v-card flat>
            <Products />
          </v-card>
        </v-tab-item>
        <v-tab-item value="users">
          <v-card flat>
            <Users />
          </v-card>
        </v-tab-item>
      </v-tabs-items>
    </template>
  </two-cols>
</template>
<script>
import TwoCols from "~/components/columns/twoColumns";
import ProductCategories from "~/components/dashboard/productCategories/index.vue";
import ProductFeatures from "~/components/dashboard/productFeatures/index.vue";
import Products from "~/components/dashboard/products/index.vue";
import Users from "~/components/dashboard/users/index.vue";
export default {
  components: {
    TwoCols,
    ProductCategories,
    ProductFeatures,
    Products,
    Users
  },
  layout: "dashboard",
  data() {
    return {
      tab: null
    };
  }
};
</script>
