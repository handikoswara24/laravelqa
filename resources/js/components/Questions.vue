<template>
  <div>
    <div class="card-body">
      <spinner v-if="$root.loading"></spinner>
      <div v-else-if="questions.length">
        <question-excerpt
          v-for="question in questions"
          :question="question"
          :key="question.id"
        ></question-excerpt>
      </div>
      <div class="alert alert-warning" v-else>
        <strong>Sorry</strong> There are no questions available.
      </div>
    </div>
    <div class="card-footer" v-if="questions.length > 0">
      <pagination
        :meta="meta"
        :links="links"
        :questions="questions"
      ></pagination>
    </div>
  </div>
</template>

<script>
import QuestionExcerpt from "./QuestionExcerpt.vue";
import Pagination from "./Pagination.vue";
import eventBus from "../event-bus.js";
export default {
  components: { QuestionExcerpt, Pagination },
  data() {
    return {
      questions: [],
      meta: {},
      links: {},
    };
  },
  methods: {
    fetchQuestions() {
      axios.get("/questions", { params: this.$route.query }).then(
        ({ data }) => {
          this.questions = data.data;
          this.meta = data.meta;
          this.links = data.links;
        },
        (err) => {}
      );
    },
    remove(index) {
      this.fetchQuestions();
      // this.questions.splice(index, 1);
      // this.count--;
    },
  },
  mounted() {
    this.fetchQuestions();
    eventBus.$on("deleted", (id) => {
      let index = this.questions.findIndex((question) => id === question.id);
      this.remove(index);
    });
  },
  watch: {
    $route: "fetchQuestions",
  },
};
</script>