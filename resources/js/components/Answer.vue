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
            alert(res.data.message);
          },
          (err) => {
            alert(err.response.data.message);
          }
        );
    },
    destroy() {
      if (confirm("Are you sure?")) {
        axios.delete(this.endPoint).then(
          (res) => {
            $(this.$el).fadeOut(500, () => {
              alert(res.data.message);
            });
          },
          (err) => {}
        );
      }
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