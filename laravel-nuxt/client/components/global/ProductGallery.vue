<template>
  <v-card>
    <v-card-title>Preview:</v-card-title>
    <draggable
      v-model="imagesSequence"
      group="images"
      class="d-flex flex-wrap"
      @start="drag = true"
      @end="finishDrag"
    >
      <v-img
        v-for="(image, index) in imagesSequence"
        :key="index"
        :src="imagesToShow(image)"
        alt=""
        contain
        max-height="100"
        max-width="100"
        class="ma-5"
      >
        <v-btn small class="x-btn" @click.prevent="deleteImage(index)">
          <v-icon>
            mdi-alpha-x-box-outline
          </v-icon>
        </v-btn>
      </v-img>
    </draggable>
  </v-card>
</template>

<script>
import draggable from "vuedraggable";

export default {
  components: {
    draggable
  },
  props: ["value"],
  data() {
    return {
      imagesSequence: this.value,
      env: process.env.serverUrl
    };
  },
  watch: {
    value(newVal, oldVal) {
      this.imagesSequence = newVal;
    }
  },
  methods: {
    finishDrag() {
      this.drag = false;
      this.$emit("input", this.imagesSequence);
    },
    imagesToShow(image) {
      return image.id ? this.env + image.url : image.url;
    },
    deleteImage(index) {
      this.imagesSequence.splice(index, 1);
      this.$emit("input", this.imagesSequence);
    }
  }
};
</script>
<style scoped>
.x-btn.v-btn.v-btn--contained.v-size--small {
  max-width: 10px;
  position: absolute;
  top: 5px;
  right: 5px;
  padding: 0px !important;
}
</style>
