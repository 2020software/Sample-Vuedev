import destroy from './destroy'

// Answer.vueとQuetion.vueの共通部分をmixinsとして利用
export default {
    mixins: [ destroy ],

    data () {
        return {
            editing: false
        }
    },

    methods: {
        edit () {
            this.setEditCache();
            this.editing = true;
        },

        cancel () {
            this.restoreFromCache();
            this.editing = false;
        },

        // Answer.vueとQUestion.vueの異なる部分は各ファイルにメソッドの内容を設定
        setEditCache () {},
        restoreFromCache () {},

        update () {
            axios.put(this.endpoint, this.payload())
            .catch(({ response }) => {
                this.$toast.error(response.data.message, "Error", { timeout: 3000 });
            })
            .then(({ data }) => {
                this.bodyHtml = data.body_html;
                this.$toast.success(data.message, "Success", { timeout: 3000 });
                this.editing = false;
            })
        },

        payload () {}
    }
}