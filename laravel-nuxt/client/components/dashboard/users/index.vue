<template>
  <div>
    <v-card flat>
      <All :all-items="allItems" @deleteItem="deleteItem" @baseTab="baseTab" />
    </v-card>
  </div>
</template>
<script>
import All from "./all";
import * as service from "~/services/Users";
export default {
  components: {
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
      this.allItems = data;
    },
    async deleteItem(id) {
      const data = await service.deleteItem(id);
      this.allItems = data;
    }
  }
};
</script>
