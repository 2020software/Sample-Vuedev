<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2>質問を編集...</h2>
                            <div class="ml-auto">
                                <router-link :to="{ name: 'questions' }" class="btn btn-outline-secondary">すべての質問へ戻る</router-link>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <question-form @submitted="update" :is-edit="true"></question-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import QuestionForm from '../components/QuestionForm.vue'
import EventBus from '../event-bus'

export default {
    components: { QuestionForm },

    methods: {
        update (data) {
            // put で更新
            axios.put('/questions/' + this.$route.params.id, data)
                .then(({ data }) => {
                    this.$router.push({ name: 'questions' })    // 作成したらすべての質問ページへ
                    this.$toast.success(data.message, "Success")
                })
                .catch(({ response }) => {
                    //  エラーメッセージをQuestionForm.vueに送り返す
                    EventBus.$emit('error', response.data.errors)
                })
        }
    }
}
</script>