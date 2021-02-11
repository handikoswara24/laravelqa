<template>
  <div class="text-center spinner" :style="getMinWidth">
    <i class="fa fa-spinner fa-spin" :class="sizeClass"></i>
  </div>
</template>

<style lang="scss" scoped>
.spinner {
  color: #ddd;
}
</style>
<script>
export default {
  props: {
    small: {
      type: Boolean,
      default: false,
    },
    minWidth: {
      type: Number,
      default: 109.61,
    },
  },
  computed: {
    sizeClass() {
      return this.small ? "" : "fa-3x";
    },
    getMinWidth() {
      return {
        minWidth: this.minWidth + "px",
      };
    },
  },
};
</script>