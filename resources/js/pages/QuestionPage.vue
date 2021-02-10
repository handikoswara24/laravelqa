<template>
  <div class="container" v-if="question.id">
    <question :question="question"></question>
    <answers :question="question"></answers>
  </div>
</template>

<script>
import Question from "../components/Question.vue";
import Answers from "../components/Answers.vue";

export default {
  props: ["slug"],
  components: { Question, Answers },
  data() {
    return {
      question: {
        title: "",
        body: "",
        id: "",
      },
    };
  },
  methods: {
    fetchQuestion() {
      axios.get(`/questions/${this.slug}`).then(
        ({ data }) => {
          this.question = data.data;
        },
        (err) => {
          console.log(err);
        }
      );
    },
  },
  mounted() {
    this.fetchQuestion();
  },
};
</script>