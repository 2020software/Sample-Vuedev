<template>
    <div>
        <!-- 未チェック -->
        <a v-if="canAccept" title="Mark this answer as best answer"
            :class="classes" @click.prevent="create">
            <i class="fa fa-check fa-2x"></i>
        </a>
        
        <!-- チェック済み -->
        <a v-if="accepted" title="The question owner accepted this as best answer"
            :class="classes">
            <i class="fa fa-check fa-2x"></i>
        </a>
    </div>
</template>

<script>
import EventBus from '../event-bus';
// チェックを一つだけ可能にするため、AnswerPolicy.php
// _vote.blade.php
export default {
    // Answer.php
    props: ['answer'],

    data () {
        return {
            isBest: this.answer.is_best,
            id: this.answer.id
        }
    },

    created () {
        EventBus.$on('accepted', id => {
            this.isBest = (id === this.id);
        })
    },

    methods: {
        create () {
            axios.post(`/answers/${this.id}/accept`)
                .then(res => {
                    this.$toast.success(res.data.message, 'Success', {
                        timeout: 3000,
                        position: 'bottomLeft'
                    });

                    this.isBest = true;

                    EventBus.$emit('accepted', this.id);
                })
        }
    },

    computed: {
        canAccept () {
            // authorize.js
            return this.authorize('accept', this.answer);
        },

        accepted () {
            return !this.canAccept && this.isBest;
        },

        classes () {
            return [
                'mt-2',
                this.isBest ? 'vote-accepted' : ''
            ];
        }
    }
}
</script>