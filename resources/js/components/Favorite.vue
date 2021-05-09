<template>
    <div>
        <a title="Click to mark as favorite question (Click again to undo)"
            :class="classes" @click.prevent="toggle">
            <i class="fa fa-star fa-2x"></i>
            <span class="favorites-count">{{ count }}</span>
        </a>
    </div>
</template>

<script>
export default {
    // Question.php
    props: ['question'],

    data () {
        return {
            isFavorited: this.question.is_favorited,
            count: this.question.favorites_count,
            id: this.question.id
        }
    },

    computed: {
        classes () {
            return [
                'favorite', 'mt-2', // 2つのクラス付与
                this.signedIn ? (this.isFavorited ? 'favorited' : '') : 'off'
            ];
        },

        endpoint () {
            return `/questions/${this.id}/favorites`;
        }
    },

    methods: {
        toggle () {
            if (! this.signedIn) {
                this.$toast.warning('ログインが必要です', 'Warning', {
                    timeout: 3000,
                    position: 'bottomLeft'
                });
                return;
            }

            this.isFavorited ? this.destroy() : this.create();
        },

        destroy () {
            axios.delete(this.endpoint)
                .then(res => {
                    this.count--;
                    this.isFavorited = false;
                });
        },

        create () {
            axios.post(this.endpoint)
                .then(res => {
                    this.count++;
                    this.isFavorited = true;
                });
        }
    }
}
</script>