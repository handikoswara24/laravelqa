<template>
  <div class="row mt-4">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">
            <div class="card-title">
              <h3>Your Answer</h3>
            </div>
            <hr />
            <form @submit.prevent="create">
              <div class="form-group">
                <textarea
                  class="form-control"
                  rows="7"
                  name="body"
                  required
                  v-model="body"
                ></textarea>
              </div>
              <div class="form-group">
                <button
                  type="submit"
                  :disabled="isInvalid"
                  class="btn btn-lg btn-outline-primary"
                >
                  <spinner
                    :small="true"
                    :min-width="59.22"
                    v-if="$root.loading"
                  ></spinner>
                  <span v-else>Submit</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["questionId"],
  data() {
    return {
      body: "",
    };
  },
  computed: {
    isInvalid() {
      return !this.signIn || this.body.trim().length < 3;
    },
  },
  methods: {
    create() {
      axios
        .post(`/questions/${this.questionId}/answers`, {
          body: this.body,
        })
        .then(
          ({ data }) => {
            this.$toast.success(data.message, "Success");
            this.body = "";
            this.$emit("created", data.answer);
          },
          (err) => {
            this.$toast.error(err.response.data.message, "Error");
          }
        );
    },
  },
};
</script>