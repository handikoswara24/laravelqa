<template>
  <div>
    <div class="card-body">
      <div v-if="questions.length">
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
      axios
        .get("/questions", { params: this.$route.query })
        .then(({ data }) => {
          this.questions = data.data;
          this.meta = data.meta;
          this.links = data.links;
        });
    },
  },
  mounted() {
    this.fetchQuestions();
  },
  watch: {
    $route: "fetchQuestions",
  },
};
</script>