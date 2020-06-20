<template>
    <div class="row justify-content-center mt-2">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>Your Answer</h2>
                    </div>
                    <form @submit.prevent="create()">
                        <div class="form-group">
                            <textarea class="form-control" v-model="body" id="body" required rows="10"></textarea>
                        </div>
                        <button type="submit" :disabled="isInvalid" class="btn btn-outline-primary">Answer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['questionId'],
        data() {
            return {
                body: '',
            };
        },
        methods: {
            create() {
                axios.post(`/questions/${this.questionId}/answers`, {body: this.body}).then(({data}) => {
                    this.$toast.success(data.message, 'Success', {
                        timeout: 6000,
                        position: 'topRight'
                    });
                    this.body = '';
                    this.$emit('created', data.answer);
                }).catch(err => {
                    this.$toast.error(err.response.data.message, 'Error', {
                        timeout: 6000,
                        position: 'topRight'
                    });
                });
            }
        },
        computed: {
            isInvalid() {
                return !this.signedIn || this.body.length < 10;
            }
        }
    }
</script>
