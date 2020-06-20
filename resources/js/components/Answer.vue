<template>
    <div class="media" style="border-bottom: 1px solid #f2f2f2; padding: 1rem;">
        <vote :model="answer" name="answer"></vote>
        <div class="media-body">
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group">
                    <label for="body">Your Answer</label>
                    <textarea v-model="body" class="form-control" name="body" id="body" rows="10"></textarea>
                </div>
                <button class="btn btn-primary btn-sm" type="submit" :disabled="isInvalid">Update
                </button>
                <button class="btn btn-outline-danger btn-sm" type="button" @click="cancel">Cancel
                </button>
            </form>
            <div v-else>
                <div v-html="bodyHtml"></div>
                <div class="row">
                    <div class="col-md-4">
                        <a v-if="authorize('modify', answer)" @click.prevent="edit" href="#"
                           class="btn btn-primary btn-sm">
                            Edit </a>
                        <button v-if="authorize('modify', answer)" @click="destroy"
                                class="d-inline btn btn-outline-danger btn-sm">
                            Delete
                        </button>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <author-info :model="answer" label="Answered"></author-info>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
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
                            this.$emit('deleted');
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
