<template>
  <form @submit.prevent="handleSubmit">
    <div class="form-group">
      <label for="question-title">Question Title</label>
      <input
        type="text"
        name="title"
        v-model="title"
        :class="errorClass('title')"
      />

      <div v-if="error['title'][0]" class="invalid-feedback">
        <strong>{{ error["title"][0] }}</strong>
      </div>
    </div>
    <div class="form-group">
      <label for="question-body">Explain your question</label>
      <m-editor :body="body" :keyId="'create-question'">
        <textarea
          name="body"
          rows="10"
          :class="errorClass('body')"
          v-model="body"
        ></textarea>

        <div v-if="error['body'][0]" class="invalid-feedback">
          <strong>{{ error["body"][0] }}</strong>
        </div>
      </m-editor>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-outline-primary btn-lg">
        {{ buttonText }}
      </button>
    </div>
  </form>
</template>

<script>
import EventBus from "../event-bus.js";
import MEditor from "./MEditor.vue";
export default {
  components: { MEditor },
  data() {
    return {
      title: "",
      body: "",
      error: {
        body: [],
        title: [],
      },
    };
  },
  mounted() {
    EventBus.$on("error", (error) => (this.error = error));
  },
  computed: {
    buttonText() {
      return "Ask Question";
    },
  },
  methods: {
    handleSubmit() {
      this.$emit("submitted", {
        title: this.title,
        body: this.body,
      });
    },
    errorClass(column) {
      return [
        "form-control",
        this.error[column] && this.error[column][0] ? "is-invalid" : "",
      ];
    },
  },
};
</script>