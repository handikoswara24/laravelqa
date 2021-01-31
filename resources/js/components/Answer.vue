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
export default {
  props: ["answer"],
  data() {
    return {
      editing: false,
      body: this.answer.body,
      bodyHtml: this.answer.body_html,
      id: this.answer.id,
      questionId: this.answer.question_id,
      beforeEditCache: null,
    };
  },
  methods: {
    edit() {
      this.beforeEditCache = this.body;
      this.editing = true;
    },
    cancel() {
      this.body = this.beforeEditCache;
      this.editing = false;
    },
    update() {
      axios
        .patch(this.endPoint, {
          body: this.body,
        })
        .then(
          (res) => {
            this.bodyHtml = res.data.body_html;
            this.editing = false;
            this.$toast.success(res.data.message, "Success", { timeout: 3000 });
          },
          (err) => {
            this.$toast.error(err.response.data.message, "Error", {
              timeout: 3000,
            });
          }
        );
    },
    destroy() {
      this.$toast.question("Are you sure about that?", "Confirm", {
        timeout: 20000,
        close: false,
        overlay: true,
        displayMode: "once",
        id: "question",
        zindex: 999,
        title: "Hey",
        message: "Are you sure about that?",
        position: "center",
        buttons: [
          [
            "<button><b>YES</b></button>",
            (instance, toast) => {
              axios.delete(this.endPoint).then(
                (res) => {
                  $(this.$el).fadeOut(500, () => {
                    this.$toast.success(res.data.message, "Success", {
                      timeout: 3000,
                    });
                  });
                },
                (err) => {}
              );
              instance.hide({ transitionOut: "fadeOut" }, toast, "button");
            },
            true,
          ],
          [
            "<button>NO</button>",
            function (instance, toast) {
              instance.hide({ transitionOut: "fadeOut" }, toast, "button");
            },
          ],
        ],
      });
    },
  },
  computed: {
    isInvalid() {
      return this.body.trim().length < 10;
    },
    endPoint() {
      return `/questions/${this.questionId}/answers/${this.id}`;
    },
  },
};
</script>