<template>
  <div>
    <spinner v-if="loading"></spinner>
    <div class="container" v-else-if="question.id">
      <question :question="question"></question>
      <answers :question="question"></answers>
    </div>
  </div>
</template>

<script>
import Question from "../components/Question.vue";
import Answers from "../components/Answers.vue";
import Spinner from "../components/Spinner.vue";

export default {
  props: ["slug"],
  components: { Question, Answers, Spinner },
  data() {
    return {
      question: {
        title: "",
        body: "",
        id: "",
      },
      loading: false,
    };
  },
  methods: {
    fetchQuestion() {
      this.loading = true;
      axios.get(`/questions/${this.slug}`).then(
        ({ data }) => {
          this.question = data.data;
          this.loading = false;
        },
        (err) => {
          console.log(err);
          this.loading = false;
        }
      );
    },
  },
  mounted() {
    this.fetchQuestion();
  },
};
</script>