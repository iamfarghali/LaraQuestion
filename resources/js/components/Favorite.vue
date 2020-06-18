<template>
    <div>
        <a href="#" title="CLick to mark as favorite (Click again to undo)"
           :class="classes" @click.prevent="toggle">
            <i class="fas fa-star fa-2x"></i>
            <span class="favorite-counts">{{favoritesCount}}</span>
        </a>
    </div>
</template>

<script>
    export default {
        props: ['question'],
        data: function () {
            return {
                isFavorited: this.question.is_favorited,
                favoritesCount: this.question.favorites_count,
                id: this.question.id
            };
        },
        computed: {
            classes() {
                return [
                    'favorite',
                    this.signedIn ? (this.isFavorited ? 'favorited' : '') : 'off'
                ];
            },
            endpoint() {
                return `/questions/${this.id}/favorites`;
            },
        },
        methods: {
            toggle() {
                if (!this.signedIn) {
                    this.$toast.warning("Please login to be able to favorite it.", "warning", {
                        timeout: 6000,
                        position: 'topRight'
                    });
                    return;
                }
                this.isFavorited ? this.unfavorited() : this.favorited();
            },
            favorited() {
                axios.post(this.endpoint).then(res => {
                    this.favoritesCount++;
                    this.isFavorited = true;
                });
            },
            unfavorited() {
                axios.delete(this.endpoint).then(res => {
                    this.favoritesCount--;
                    this.isFavorited = false;
                });
            }
        }
    }
</script>
