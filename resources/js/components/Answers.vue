<template>
  <div>
    <spinner v-if="loading"></spinner>
    <div class="row mt-4" v-cloak v-else-if="count">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="card-title">
              <h2>{{ title }}</h2>
            </div>
            <hr />
            <answer
              @deleted="remove(index)"
              v-for="(answer, index) in answers"
              :answer="answer"
              :key="answer.id"
            ></answer>
            <div class="text-center mt-3" v-if="nextUrl">
              <button
                @click.prevent="fetch(theNextUrl)"
                class="btn btn-outline-secondary"
              >
                Load more answers
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <new-answer @created="add" :question-id="questionId"></new-answer>
  </div>
</template>

<script>
import Answer from "./Answer.vue";
import NewAnswer from "./NewAnswer.vue";
import EventBus from "../event-bus.js";
import Spinner from "./Spinner.vue";
export default {
  props: ["question"],
  data() {
    return {
      questionId: this.question.id,
      count: this.question.answers_count,
      answers: [],
      nextUrl: null,
      excludeAnswers: [],
      loading: false,
    };
  },
  methods: {
    add(answer) {
      this.excludeAnswers.push(answer);
      this.answers.push(answer);
      this.count++;
      if (this.count == 1) {
        EventBus.$emit("answers-count-changed", this.count);
      }
    },
    remove(index) {
      this.answers.splice(index, 1);
      this.count--;
      if (this.count == 0) {
        EventBus.$emit("answers-count-changed", this.count);
      }
    },
    fetch(endpoint) {
      this.loading = true;
      axios.get(endpoint).then(
        ({ data }) => {
          this.answers.push(...data.data);
          this.nextUrl = data.links.next;
          this.loading = false;
        },
        (err) => {
          this.loading = false;
        }
      );
    },
  },
  created() {
    this.fetch(`/questions/${this.questionId}/answers`);
  },
  computed: {
    title() {
      return this.count + " " + (this.count > 1 ? "Answers" : "Answer");
    },
    theNextUrl() {
      if (this.nextUrl && this.excludeAnswers.length) {
        return (
          this.nextUrl +
          this.excludeAnswers.map((a) => "&excludes[]=" + a.id).join("")
        );
      }
      return this.nextUrl;
    },
  },
  components: {
    Answer,
    NewAnswer,
    Spinner,
  },
};
</script>