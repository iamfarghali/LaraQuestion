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
    import modifications from "../mixins/modifications";

    export default {
        props: ['answer'],
        mixins: [modifications],
        data: function () {
            return {
                body: this.answer.body,
                bodyHtml: this.answer.body_html,
                id: this.answer.id,
                questionId: this.answer.question_id,
                cachedAnswer: null,
            };
        },
        methods: {
            cacheData() {
                this.cachedAnswer = this.body;
            },
            restoreCachedData() {
                this.body = this.cachedAnswer;
            },
            payload() {
                return {
                    body: this.body
                };
            },
            setReturnedData(data) {
                this.bodyHtml = data.answer.body_html;
                this.body = data.answer.body;
            },
            afterDeleting() {
                this.$emit('deleted');
            }
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
