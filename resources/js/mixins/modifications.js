import destroy from "./destroy.js"

export default {
    mixins: [destroy],
    data() {
        return {
            editing: false
        }
    },

    methods: {
        edit() {
            this.setEditCache();
            this.editing = true;
        },

        cancel() {
            this.restoreFromCache();
            this.editing = false;
        },

        setEditCache() { },
        restoreFromCache() { },

        update() {
            axios
                .put(this.endpoint, this.payload())
                .then(
                    ({ data }) => {
                        this.bodyHtml = data.body_html;
                        this.$toast.success(data.message, "Success", { timeout: 3000 });
                        this.editing = false;
                    },
                    ({ response }) => {
                        this.$toast.error(response.data.message, "Error", {
                            timeout: 3000,
                        });
                    }
                );
        },

        payload() { },


    }
}