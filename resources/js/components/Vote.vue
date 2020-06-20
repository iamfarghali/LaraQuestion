<template>
    <div class="d-flex flex-column votes-controls">
        <a href="#" :title="title('up')" class="vote-up"
           @click.prevent="voteUp()"
           :class="classes">
            <i class="fas fa-caret-up fa-4x"></i>
        </a>
        <span class="votes-count">{{count}}</span>
        <a href="#" :title="title('down')" class="vote-down"
           @click.prevent="voteDown()"
           :class="classes">
            <i class="fas fa-caret-down fa-4x"></i>
        </a>
        <favorite v-if="name === 'question'" :question="model"></favorite>
        <accept v-else :answer="model"></accept>
    </div>

</template>

<script>
    import Favorite from "./Favorite";
    import Accept from "./Accept";

    export default {
        props: ['name', 'model'],
        components: {
            Favorite,
            Accept
        },
        data() {
            return {
                count: this.model.votes_count || 0,
                id: this.model.id
            }
        },
        computed: {
            classes() {
                return [
                    this.signedIn ? '' : 'off'
                ];
            },
            endpoint() {
                return `/${this.name}s/${this.id}/vote`;
            }
        },
        methods: {
            title(voteType) {
                let titles = {
                    'up': `This ${this.name} is useful`,
                    'down': `This ${this.name} is not useful`,
                }
                return titles[voteType];
            },
            voteUp() {
                this._vote(1);
            },
            voteDown() {
                this._vote(-1);
            },
            _vote(vote) {
                if (!this.signedIn) {
                    this.$toast.warning('Please login.', 'Warning', {timeout: 6000, position: 'topRight'});
                    return;
                }
                axios.post(this.endpoint, {vote}).then(res => {
                    this.$toast.success(res.data.message, 'Success', {timeout: 6000, position: 'topRight'});
                    this.count = res.data.votesCount;
                });
            }
        }
    }
</script>
