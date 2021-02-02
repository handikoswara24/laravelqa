<template>
  <div class="media post">
    <vote :model="answer" name="answer"></vote>
    <div class="media-body">
      <form v-if="editing" @submit.prevent="update">
        Edit Answer Form
        <div class="form-group">
          <textarea
            class="form-control"
            v-model="body"
            rows="10"
            required
          ></textarea>
        </div>
        <button type="submit" class="btn btn-primary" :disabled="isInvalid">
          Update
        </button>
        <button @click="cancel" class="btn btn-outline-secondary">
          Cancel
        </button>
      </form>
      <div v-else>
        <div v-html="bodyHtml"></div>
        <div class="row">
          <div class="col-4">
            <div class="ml-auto">
              <a
                v-if="authorize('modify', answer)"
                @click.prevent="edit"
                class="btn btn-sm btn-outline-info"
                >Edit</a
              >
              <button
                v-if="authorize('modify', answer)"
                @click="destroy"
                class="btn btn-outline-danger btn-sm"
              >
                Delete
              </button>
            </div>
          </div>
          <div class="col-4"></div>
          <div class="col-4 text-right">
            <user-info :model="answer" :label="'Answered'"></user-info>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vote from "./Vote.vue";
import UserInfo from "./UserInfo.vue";
import modification from "../mixins/modifications";

export default {
  props: ["answer"],
  components: { Vote, UserInfo },
  mixins: [modification],
  data() {
    return {
      body: this.answer.body,
      bodyHtml: this.answer.body_html,
      id: this.answer.id,
      questionId: this.answer.question_id,
      beforeEditCache: null,
    };
  },
  methods: {
    setEditCache() {
      this.beforeEditCache = this.body;
    },
    restoreFromCache() {
      this.body = this.beforeEditCache;
    },
    payload() {
      return {
        body: this.body,
      };
    },
    delete() {
      axios.delete(this.endpoint).then(
        ({ data }) => {
          this.$emit("deleted");
          this.$toast.success(data.message, "Success", {
            timeout: 2000,
          });
          // $(this.$el).fadeOut(500, () => {
          //   this.$toast.success(res.data.message, "Success", {
          //     timeout: 3000,
          //   });
          // });
        },
        (err) => {}
      );
    },
  },
  computed: {
    isInvalid() {
      return this.body.trim().length < 10;
    },
    endpoint() {
      return `/questions/${this.questionId}/answers/${this.id}`;
    },
  },
};
</script>