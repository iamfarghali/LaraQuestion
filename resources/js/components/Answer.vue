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
                cachedAnswer: null,
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
                axios.patch(this.endpoint, {
                    body: this.body
                }).then(res => {
                    console.log('Done');
                    this.bodyHtml = res.data.body_html;
                    this.editing = false;
                    this.$toast.success(res.data.message, 'Success', {timeout: 6000, position: 'topRight'});
                }).catch(err => {
                    this.editing = false;
                    this.$toast.error(err.response.data.message, 'Error', {timeout: 6000, position: 'topRight'});
                });
            },
            destroy: function () {
                this.$toast.question('Are you sure about that?', 'Confirm', {
                    timeout: 20000, close: false,
                    overlay: true, displayMode: 'once',
                    id: 'question', zindex: 999, title: 'Hey',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', (instance, toast) => {
                            axios.delete(this.endpoint).then(res => {
                                $(this.$el).fadeOut(750, () => {
                                    this.$toast.success(res.data.message, 'Success', {timeout: 6000, position: 'topRight'});
                                });
                            });
                            instance.hide({transitionOut: 'fadeOut'}, toast, 'button');

                        }, true],
                        ['<button>NO</button>', (instance, toast) => {

                            instance.hide({transitionOut: 'fadeOut'}, toast, 'button');

                        }],
                    ],
                });
            },
        },
        computed: {
            isInvalid() {
                return this.body.length < 10;
            },
            endpoint() {
                return `/questions/${this.questionId}/answers/${this.id}`;
            },
        },

    }
</script>
