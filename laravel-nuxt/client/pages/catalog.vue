<template>
  <div class="container">
    <v-card-subtitle>
      {{ currentCategory.name }}
    </v-card-subtitle>
    <n-link
      v-if="parentCategory"
      class="category"
      :to="{ name: 'categories', params: { slug: parentCategory.slug } }"
    >
      ...
    </n-link>
    <n-link
      v-for="(category, key) in childCategories"
      :key="key"
      class="category"
      :to="{ name: 'category', params: { slug: category.slug } }"
    >
      <v-img :src="category.url" />
    </n-link>
  </div>
</template>

<script>
import { mapMutations } from "vuex";
export default {
  layout: "simple",
  data() {
    return {
      categories: []
    };
  },
  head() {
    return { title: "All categories" };
  },
  computed: {
    childCategories() {
      return this.categories?.filter(
        cat => cat.parent_id === this.currentCategory.id
      );
    },
    currentCategory() {
      const slug = this.$route.params.slug;
      let result;
      if (!slug) {
        result = this.categories.filter(cat => cat.id === 1)[0];
      } else {
        result = this.categories.filter(cat => cat.slug === slug)[0];
      }
      return result;
    },
    parentCategory() {
      return this.categories.filter(
        cat => cat.id === this.currentCategory.parent_id
      )[0];
    }
  },
  created() {
    const categories = this.$store.state.categories.categories;
    if (categories) {
      this.categories = this.$store.state.categories.categories;
    }
  },
  beforeMount() {
    if (this.childCategories.length === 0) {
      this.$router.push({
        name: "category",
        params: { category: this.currentCategory.slug }
      });
    }
  }
};
</script>
<style scoped>
.container {
  border: 1px red solid;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  grid-gap: 10px;
}
.category {
  border: 1px solid black;
  min-height: 150px;
}
</style>
