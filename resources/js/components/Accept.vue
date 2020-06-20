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
    import EventBus from "../event-bus";

    export default {
        props: ['answer'],
        data() {
            return {
                isBest: this.answer.is_best,
                id: this.answer.id
            };
        },
        created() {
            EventBus.$on('accept', id => {
                this.isBest = (id === this.id);
            });
        },
        methods: {
            accepted() {
                axios.post(this.endpoint).then(res => {
                    this.$toast.success(res.data.message, 'Success', {
                        timeout: 6000,
                        position: 'topRight'
                    });
                    EventBus.$emit('accept', this.id);
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
                return `/answers/${this.id}/accept `
            }
        }
    }
</script>
