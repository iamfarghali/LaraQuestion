<template>
    <div>
        <a v-if="canAccept" href="#" title="Mark this answer as the best answer."
           @click.prevent="accepted"
           :class="classes">
            <i class="fas fa-check fa-2x"></i>
        </a>
        <a v-if="isAccepted" href="#" title="This answer marked as the best answer by question's owner."
           :class="classes">
            <i class="fas fa-check fa-2x"></i>
        </a>
    </div>
</template>

<script>
    export default {
        props: ['answer'],
        data() {
            return {
                isBest: this.answer.is_best
            };
        },
        methods: {
            accepted() {
                axios.post(this.endpoint).then(res => {
                    this.$toast.success(res.data.message, 'Success', {
                        timeout: 6000,
                        position: 'topRight'
                    });
                    this.isBest = true;
                });
            }
        },
        computed: {
            canAccept() {
                return this.authorize('accept', this.answer);
            },
            isAccepted() {
                return !this.canAccept && this.isBest;
            },
            classes() {
                return [
                    'mt-2',
                    this.isBest ? 'vote-accepted' : ''
                ];
            },
            endpoint() {
                return `/answers/${this.answer.id}/accept `
            }
        }
    }
</script>
