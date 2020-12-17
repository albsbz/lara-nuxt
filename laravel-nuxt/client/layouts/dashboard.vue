<template>
  <div class="layout">
    <!-- <navbar /> -->
    layout
    <div class="container mt-4">
      <nuxt />
    </div>
  </div>
</template>

<script>
// import Navbar from '~/components/Navbar'

export default {
  middleware: ["auth", "admin"],
  components: {
    // Navbar
  }
};
</script>
