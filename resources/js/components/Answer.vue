<script>
    export default {
        props: ['answer'],
        data: function () {
            return {
                editing: false,
                body: this.answer.body,
                bodyHtml: this.answer.body_html,
                id: this.answer.id,
                questionId: this.answer.question_id,
                cachedAnswer: null
            };
        },
        methods: {
            edit: function () {
                this.cachedAnswer = this.body;
                this.editing = true;
            },
            cancel: function () {
                this.body = this.cachedAnswer;
                this.editing = false;
            },
            update: function () {
                axios.patch(`/questions/${this.questionId}/answers/${this.id}`, {
                    body: this.body
                }).then(res => {
                    console.log('Done');
                    this.bodyHtml = res.data.body_html;
                    this.editing = false;
                    alert(res.data.message);
                }).catch(err => {
                    this.editing = false;
                    alert(err.response.data.message);
                });
            }
        },
        computed: {
            isInvalid() {
                return this.body.length < 10;
            }
        },

    }
</script>
