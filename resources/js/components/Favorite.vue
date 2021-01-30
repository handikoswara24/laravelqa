<template>
  <a
    title="Click to mark as favorite question (Click again to undo)"
    :class="classes"
    @click.prevent="toggle"
  >
    <i class="fas fa-star fa-2x"></i>
    <span class="favorite-count">{{ count }}</span>
  </a>
</template>
<script>
export default {
  props: ["question"],
  data() {
    return {
      isFavorited: this.question.is_favorited,
      count: this.question.favorites_count,
      id: this.question.id,
    };
  },
  computed: {
    classes() {
      return [
        "favorite",
        "mt-2",
        !this.signIn ? "off" : this.isFavorited ? "favorited" : "",
      ];
    },
    endPoint() {
      return `/questions/${this.id}/favorites`;
    },
    signIn() {
      return window.Auth.signIn;
    },
  },
  methods: {
    toggle() {
      if (!this.signIn) {
        this.$toast.warning(
          "Please login to favorite this question",
          "Warning",
          {
            timeout: 3000,
            position: "bottomLeft",
          }
        );
        return;
      }
      this.isFavorited ? this.destroy() : this.create();
    },
    destroy() {
      axios.delete(this.endPoint).then(
        (res) => {
          this.count--;
          this.isFavorited = false;
        },
        (err) => {}
      );
    },
    create() {
      axios.post(this.endPoint).then(
        (res) => {
          this.count++;
          this.isFavorited = true;
        },
        (err) => {}
      );
    },
  },
};
</script>