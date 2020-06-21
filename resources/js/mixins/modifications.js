export default {
    data() {
        return {
            editing: false,
            timeout: 3000,
            successTimeout: 2000,
            position: 'topRight'
        };
    },

    methods: {
        edit() {
            this.cacheData()
            this.editing = true;
        },
        cancel: function () {
            this.restoreCachedData()
            this.editing = false;
        },
        update: function () {
            axios.put(this.endpoint, this.payload()).then(({data}) => {
                this.setReturnedData(data);
                this.editing = false;
                this.$toast.success(data.message, 'Success', {timeout: this.successTimeout, position: this.position});
            }).catch(err => {
                this.editing = false;
                this.$toast.error(err.response.data.message, 'Error', {timeout: this.timeout, position: this.position});
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
                            this.$toast.success(data.message, 'Success', {
                                timeout: this.successTimeout,
                                position: this.position
                            });
                            this.afterDeleting();
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
