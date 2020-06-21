<template>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <form class="card" v-if="editing" @submit.prevent="update">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <input type="text" class="form-control" name="title" v-model="title">
                    </div>
                </div>
                <div class="card-body">
                    <div class="media">
                        <div class="media-body">
                            <div class="form-group">
                                <label for="body">Your Question</label>
                                <textarea v-model="body" class="form-control" name="body" id="body"
                                          rows="10"></textarea>
                            </div>
                            <button class="btn btn-primary btn-sm" type="submit" :disabled="isInvalid">Update
                            </button>
                            <button class="btn btn-outline-danger btn-sm" type="button" @click="cancel">Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div v-else class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="h3">{{title}}</h1>
                        <div>
                            <a href="/questions" class="btn btn-outline-primary">Questions</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="media">
                        <vote :model="question" name="question"></vote>
                        <div class="media-body">
                            <div v-html="bodyHtml"></div>
                            <div class="row">
                                <div class="col-md-4">
                                    <a v-if="authorize('modify', question)" @click.prevent="edit" href="#"
                                       class="btn btn-primary btn-sm">
                                        Edit </a>
                                    <button v-if="authorize('deleteQuestion', question)" @click="destroy"
                                            class="d-inline btn btn-outline-danger btn-sm">
                                        Delete
                                    </button>
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <author-info :model="question" label="Asked"></author-info>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['question'],
        data() {
            return {
                title: this.question.title,
                body: this.question.body,
                bodyHtml: this.question.body_html,
                editing: false,
                id: this.question.id,
                cachedQuestion: {}
            };
        },
        computed: {
            isInvalid() {
                return this.body.length < 10 || this.title.length < 10;
            },
            endpoint() {
                return `/questions/${this.id}`;
            }
        },
        methods: {
            edit() {
                this.cachedQuestion = {
                    title: this.title,
                    body: this.body
                };
                this.editing = true;
            },
            cancel: function () {
                this.title = this.cachedQuestion.title;
                this.body = this.cachedQuestion.body;
                this.editing = false;
            },
            update: function () {
                axios.put(this.endpoint, {
                    title: this.title,
                    body: this.body
                }).then(({data}) => {
                    this.title = data.question.title;
                    this.bodyHtml = data.question.body_html;
                    this.body = data.question.body;
                    this.editing = false;
                    this.$toast.success(data.message, 'Success', {timeout: 6000, position: 'topRight'});
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
                            axios.delete(this.endpoint).then(({data}) => {
                                this.$toast.success(data.message, 'Success', {timeout: 2000, position: 'topRight'});
                                setTimeout(() => {
                                    window.location.href = '/questions';
                                }, 2200);
                            });
                            instance.hide({transitionOut: 'fadeOut'}, toast, 'button');

                        }, true],
                        ['<button>NO</button>', (instance, toast) => {
                            instance.hide({transitionOut: 'fadeOut'}, toast, 'button');
                        }],
                    ],
                });
            },
        }
    }
</script>
