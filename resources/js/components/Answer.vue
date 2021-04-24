<template>
  <div class="media post">
        <vote :model="answer" name="answer"></vote>

        <div class="media-body">
            <form v-if="editing" @submit.prevent="update">  <!-- Answer.vue - updateメソッド呼び出し -->
                <div class="form-group">
                    <textarea class="form-control" v-model="body" rows="10" required></textarea>
                </div>
                <button class="btn btn-primary" :disabled="isInvalid">更新</button>
                <button class="btn btn-outline-secondary" @click="cancel" type="button">キャンセル</button>
            </form>
            <div v-else>
                <div v-html="bodyHtml"></div>
                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            <a v-if="authorize('modify', answer)" @click.prevent="edit" class="btn btn-sm btn-outline-info">編集</a>
                            <button v-if="authorize('modify', answer)" @click="destroy" class="btn btn-sm btn-outline-danger">削除</button>
                        </div>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4">
                        <user-info :model="answer" label="Answered"></user-info>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Vote from './Vote.vue';
import UserInfo from './UserInfo.vue';
import modification from '../mixins/modification';

export default {
  // Answer.php
  props: ['answer'],

  mixins: [modification],

  components: { Vote, UserInfo },

  data() {
    return {
      body: this.answer.body,
      bodyHtml: this.answer.body_html,
      id: this.answer.id,
      questionId: this.answer.question_id,
      beforeEditCache: null,
    }
  },

  methods: {
    setEditCache () {
      this.beforeEditCache = this.body;
    },

    restoreFromCache () {
      this.body = this.beforeEditCache;
    },

    payload () {
      return {
        body: this.body
      };
    },

    delete () {
      axios.delete(this.endpoint)
        .then(res => {
          this.$toast.success(res.data.message, "Success", { timeout: 2000 });
          this.$emit('deleted')
        });
    }
  },

  computed: {
    isInvalid() {
      // 0文字なら、Updateボタンを無効にする
      return this.body.length < 1;
    },
    endpoint() {
      return `/questions/${this.questionId}/answers/${this.id}`;
    }
  }
}
</script>