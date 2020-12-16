<template>
  <div>
    <div>Test page</div>
    <div>User: {{ user }}</div>
    <div>Role: {{ roles }}</div>
    <div>Data: {{ dataFromDashboard }}</div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import axios from "axios";
export default {
  async asyncData({ $axios }) {
    const dataFromDashboard = await axios.get("/dashboard");
    return { dataFromDashboard: dataFromDashboard.data };
  },
  data() {
    return {};
  },

  computed: {
    ...mapGetters({
      user: "auth/user",
      roles: "auth/roles"
    })
  }
};
</script>
