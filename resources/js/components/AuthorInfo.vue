<template>
    <div>
        <span>{{postDate}}</span>
        <div class="media ">
            <a :href="user.url" class="pr-2">
                <img :src="user.avatar" alt="img">
            </a>
            <div class="media-body mt-1">
                <a :href="user.url">{{user.name}}</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['model', 'label'],
        data: function () {
            return {
                user: this.model.user
            };
        },
        computed: {
            postDate() {
                return this.label + " " + this.model.created_date;
            }
        }
    }
</script>
