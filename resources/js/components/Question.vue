<template>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <form class="card-body" v-if="editing" @submit.prevent="update">
          <div class="card-title">
            <input
              type="text"
              class="form-control form-control-lg"
              v-model="title"
            />
          </div>

          <hr />

          <div class="media">
            <div class="media-body">
              <div class="form-group">
                <m-editor :body="body" :keyId="'q'">
                  <textarea
                    class="form-control"
                    v-model="body"
                    rows="10"
                    required
                  ></textarea>
                </m-editor>
              </div>
              <button
                type="submit"
                class="btn btn-primary"
                :disabled="isInvalid"
              >
                Update
              </button>
              <button @click="cancel" class="btn btn-outline-secondary">
                Cancel
              </button>
            </div>
          </div>
        </form>
        <div class="card-body" v-else>
          <div class="card-title">
            <div class="d-flex align-items-center">
              <h1>{{ title }}</h1>
              <div class="ml-auto">
                <a href="/questions" class="btn btn-outline-secondary"
                  >Back to all Questions</a
                >
              </div>
            </div>
          </div>

          <hr />

          <div class="media">
            <vote :model="question" name="question"></vote>
            <div class="media-body">
              <markdown-it-vue :content="body" />
              <!-- <div v-html="bodyHtml"></div> -->
              <div class="row mt-2">
                <div class="col-4">
                  <div class="ml-auto">
                    <a
                      v-if="authorize('modify', question)"
                      @click.prevent="edit"
                      class="btn btn-sm btn-outline-info"
                      >Edit</a
                    >
                    <button
                      v-if="authorize('deleteQuestion', question)"
                      @click="destroy"
                      class="btn btn-outline-danger btn-sm"
                    >
                      Delete
                    </button>
                  </div>
                </div>
                <div class="col-4"></div>
                <div class="col-4 text-right">
                  <user-info :model="question" :label="'Asked'"></user-info>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vote from "./Vote.vue";
import UserInfo from "./UserInfo.vue";
import modification from "../mixins/modifications.js";
import MEditor from "./MEditor.vue";
import EventBus from "../event-bus.js";

export default {
  props: ["question"],
  components: { Vote, UserInfo, MEditor },
  mixins: [modification],
  data() {
    return {
      title: this.question.title,
      body: this.question.body,
      bodyHtml: this.question.body_html,
      id: this.question.id,
      beforeEditCache: {},
    };
  },
  computed: {
    isInvalid() {
      return this.body.trim().length < 3 || this.title.trim().length < 3;
    },
    endpoint() {
      return `/questions/${this.id}`;
    },
  },
  mounted() {
    EventBus.$on("answers-count-changed", (count) => {
      this.question.answers_count = count;
    });
  },
  methods: {
    setEditCache() {
      this.beforeEditCache = {
        body: this.body,
        title: this.title,
      };
    },

    restoreFromCache() {
      this.body = this.beforeEditCache.body;
      this.title = this.beforeEditCache.title;
    },
    payload() {
      return {
        body: this.body,
        title: this.title,
      };
    },
    delete() {
      axios.delete(this.endpoint).then(
        ({ data }) => {
          this.$toast.success(data.message, "Success", {
            timeout: 2000,
          });
          setTimeout(() => {
            this.$router.push({ name: "questions" });
          }, 3000);
        },
        (err) => {
          console.log(err);
        }
      );
    },
  },
};
</script>