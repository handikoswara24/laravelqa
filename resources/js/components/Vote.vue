<template>
  <div class="d-flex flex-column vote-controls">
    <a
      :title="title('up')"
      :class="classes"
      class="vote-up"
      @click.prevent="voteUp"
    >
      <i class="fas fa-caret-up fa-3x"></i>
    </a>
    <span class="votes-count">
      {{ count }}
    </span>
    <a
      :title="title('down')"
      :class="classes"
      class="vote-down"
      @click.prevent="voteDown"
    >
      <i class="fas fa-caret-down fa-3x"></i>
    </a>

    <favorite v-if="name == 'question'" :question="model"></favorite>

    <accept v-else :answer="model"></accept>
  </div>
</template>

<script>
import Favorite from "./Favorite.vue";
import Accept from "./Accept.vue";
export default {
  props: ["name", "model"],
  computed: {
    classes() {
      return this.signIn ? "" : "off";
    },
    endpoint() {
      return `/${this.name}s/${this.id}/vote`;
    },
  },
  components: {
    Favorite,
    Accept,
  },
  data() {
    return {
      count: this.model.votes_count || 0,
      id: this.model.id,
    };
  },
  methods: {
    title(voteType) {
      let titles = {
        up: `This ${this.name} is useful`,
        down: `This ${this.name} is not useful`,
      };
      return titles[voteType];
    },
    voteUp() {
      this._vote(1);
    },
    voteDown() {
      this._vote(-1);
    },
    _vote(vote) {
      if (!this.signIn) {
        this.$toast.warning(
          `Please login to vote this ${this.name}`,
          "Warning",
          {
            timeout: 3000,
            position: "bottomLeft",
          }
        );
      }
      axios
        .post(this.endpoint, {
          vote,
        })
        .then(
          (res) => {
            this.$toast.success(res.data.message, "Success", {
              timeout: 3000,
              position: "bottomLeft",
            });
            this.count = res.data.votesCount;
          },
          (err) => {}
        );
    },
  },
};
</script>